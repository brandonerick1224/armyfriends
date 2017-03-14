
//mgRtc - file helper

(function( $, window, document, undefined ){
    
    $.fn.mgFileHelper = function(rtc){
        var fileHelper = {
            getDesc: function(file){
                if(!file.id){
                    file.id = (Math.random() * new Date().getTime()).toString(36).toUpperCase().replace( /\./g , '-');
                }
                return {
                    name: file.name,
                    size: file.size,
                    type: file.type,
                    id: file.id,
                    connectionId: file.connectionId,
                    firefox: rtc.firefox
                }
            },
            send: function(file, channel, options) {
                var packetSize = 800,
                    numberOfPackets = 0,
                    packets = 0,
                    order = 0;
                var reader = new window.FileReader();
                var loadAndSend = function(event, text) {
                        var data = {
                            type: 'file',
                            name: file.name,
                            packets: 0,
                            id: file.id,
                            connectionId: file.connectionId,
                            'order': order
                        };
                        order ++;
                        //only once event is sent
                        if (event) {
                            text = event.target.result;
                            numberOfPackets = packets = data.packets = parseInt(Math.ceil(text.length / packetSize));
                        }
                        else{
                            data.packets = numberOfPackets;
                        }
                        //prepare message
                        if (text.length > packetSize){
                            data.message = text.slice(0, packetSize);
                        }                        
                        else {
                            data.message = text;
                            data.last = true;                           
                        }
                        //send over rtc
                        channel.send(JSON.stringify(data));
                        var progress = {
                            remaining: --packets,
                            length: numberOfPackets,
                            sent: numberOfPackets - packets,
                            transfered: numberOfPackets - packets,
                            fileId: data.id
                        }
                        //progress event
                        if (options.onFileProgress){
                            options.onFileProgress(progress, file);
                        }
                        //sent event
                        if(data.last && options.onFileSent){
                            options.onFileSent(progress);
                        }
                        //next text
                        text = text.slice(data.message.length);
                        var timeout = 500;
                        if(options.calcTimeout){
                            timeout = options.calcTimeout(progress);
                            //if to less 0 this is signal to stop sending
                            if(timeout < 0){
                                return;
                            }
                        }
                        //schedule next transmission
                        if (text.length) {
                            setTimeout(function() {
                                loadAndSend(null, text);
                            }, timeout);
                        }
                    };
                reader.onload = loadAndSend;
                //read actual file
                reader.readAsDataURL(file);
            },
            recContent: {},
            recPackets: {},
            recNumberOfPackets: {},        
            receive: function(data, options) {            
                var id = data.id;
                if (data.packets && !fileHelper.recNumberOfPackets[id]){
                    fileHelper.recNumberOfPackets[id] = fileHelper.recPackets[id] = parseInt(data.packets);
                }                

                if (options.onFileProgress){
                    options.onFileProgress({
                        remaining: --fileHelper.recPackets[id],
                        length: fileHelper.recNumberOfPackets[id],
                        received: fileHelper.recNumberOfPackets[id] - fileHelper.recPackets[id],
                        transfered: fileHelper.recNumberOfPackets[id] - fileHelper.recPackets[id],
                        fileId: id
                    }, id);
                }

                if (!fileHelper.recContent[id]){
                    fileHelper.recContent[id] = {};
                }
                fileHelper.recContent[id][data.order] = data.message;
                // if it is last packet
                if (data.last) {
                    var dataURL = '';
                    for(var i = 0; i < fileHelper.recNumberOfPackets[id]; i++){
                        dataURL += fileHelper.recContent[id][i];
                    }                
                    var blob = fileHelper.dataUrlToBlob(dataURL);
                    var virtualURL = (window.URL || window.webkitURL).createObjectURL(blob);

                    // if you don't want to auto-save to disk:
                    // channel.autoSaveToDisk=false;
                    if (options.autoSaveToDisk){
                        fileHelper.saveToDisk(dataURL, data.name);
                    }                    
                    // channel.onFileReceived = function(fileName, file) {}
                    // file.blob || file.dataURL || file.url || file.uuid
                    if (options.onFileReceived){
                        options.onFileReceived(data.name, {
                            blob: blob,
                            dataURL: dataURL,
                            url: virtualURL,
                            fileId: id
                        });               
                    }
                    delete fileHelper.recContent[id];
                }
            },
            saveToDisk: function(fileUrl, fileName) {
                var hyperlink = document.createElement('a');
                hyperlink.href = fileUrl;
                hyperlink.target = '_blank';
                hyperlink.download = fileName || fileUrl;

                var mouseEvent = new MouseEvent('click', {
                    view: window,
                    bubbles: true,
                    cancelable: true
                });

                hyperlink.dispatchEvent(mouseEvent);
                (window.URL || window.webkitURL).revokeObjectURL(hyperlink.href);
            },
            dataUrlToBlob: function(dataURL) {
                var binary = atob(dataURL.substr(dataURL.indexOf(',') + 1));
                var array = [];
                for (var i = 0; i < binary.length; i++) {
                    array.push(binary.charCodeAt(i));
                }

                var type;

                try {
                    type = dataURL.substr(dataURL.indexOf(':') + 1).split(';')[0];
                } catch (e) {
                    type = 'text/plain';
                }
                return new Blob([new Uint8Array(array)], {type: type});
            }
        };        
        return fileHelper;
    }

})( jQuery, window , document );   // pass the jQuery object to this function


