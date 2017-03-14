<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use MgRTC\Chat;
use MgRTC\Daemon;
use MgRTC\Server;
use MgRTC\Session\SessionProvider;
use Ratchet\Http\HttpServer;
use Ratchet\Http\OriginCheck;
use Ratchet\Server\IpBlackList;
use Ratchet\WebSocket\WsServer;

class ChatServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chat:server';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage the Video Chat Server';

    /**
     * Server Configurations
     *
     * @var array
     */

    protected $config;
    /**
     * Server Version
     *
     * @var array
     */
    protected $version = array(
        'main'  => '1.10.1',
        'build' => '$LastChangedRevision: 282 $'
    );
    /**
     * Created Server instance
     *
     * @var \Ratchet\Server\IoServer $server
     */
    protected $server = null;

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
        $this->config = config('mgrtc');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $command = 'execute';

        //Deamon igniter
        Daemon::getInstance()->run(array(
            'daemon_name' => 'mg-chat-server',
            'run'         => $this->onRun(),
            'stop'        => $this->onStop(),
            'pid_file'    => __DIR__ . '/mg-chat-server.pid'
        ), $command);
    }

    /**
     * Create WS server
     *
     * @global \Ratchet\Server\IoServer $server
     * @global array                    $config
     */
    private function createServer()
    {
        $app = new Chat($this->config);
        //ip blacklist
        if (isset($this->config['IpBlackList']) && is_array($this->config['IpBlackList'])) {
            $app = new IpBlackList($app);
            foreach ($this->config['IpBlackList'] as $ipBlackList) {
                $app->blockAddress($ipBlackList);
            }
        }
        //session
        $session = new SessionProvider($app, $this->config);
        //websocket
        $wsServer = new WsServer($session);
        //limit origins
        if (isset($this->config['allowedOrigins']) && is_array($this->config['allowedOrigins'])) {
            $wsServer = new OriginCheck($wsServer, $this->config['allowedOrigins']);
        }

        try {
            $this->server = Server::factory(new HttpServer($wsServer), $this->config['port']);
        } catch (\Exception $e) {
            \Log::error('Video chat server error: ' . $e->getMessage());
            $this->error($e->getMessage());
        }
    }

    /**
     * Start server
     *
     * @global \Ratchet\Server\IoServer $server
     */
    private function onRun()
    {
        $this->createServer();

        preg_match('/\d+/', $this->version['build'], $match);
        $build = $match[0];
        $this->info("Server version: {$this->version['main']}.{$build}, listening on port: {$this->config['port']}");

        $this->server->run();
    }

    /**
     * Stop server
     *
     * @global \Ratchet\Server\IoServer $server
     */
    private function onStop()
    {
        try {
            $this->server->socket->shutdown();
        } catch (\Exception $e) {
            \Log::error('Video chat server error: ' . $e->getMessage()) ;
            $this->error($e->getMessage());
        }
        $this->server->loop->stop();
    }
}
