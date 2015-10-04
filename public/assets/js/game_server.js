(function() {
    function bind(scope, fn) {
        var args = Array.prototype.slice.call(arguments, 2);

        return function() {
            return fn.apply(scope, args);
        }
    }

    function fetch(url) {
        var self = this;

        $.ajax({
            url: url,
            success: function(data) {
                if(!self.open) {
                    self.open = true;
                    if(fn = self.listeners['open']) {
                        fn.call(self, data);
                    };
                };

                if(data.event) {
                    if(fn = self.listeners[data.event]) {
                        fn.call(self, data);
                    };
                } else if(fn = self.listeners['message']) {
                    fn.call(self, data);
                };

                setTimeout(bind(self, fetch, url), config.turnLength);
            },
            dataType: 'json'
        });
    }

    GameServer = function(config) {
        this.url = config.url;
        this.forceAjax = config.forceAjax;
        this.open = false;
        this.listeners = {};

        if(!window.EventSource) {
            this.handler = this;
        }
    };

    GameServer.prototype.on = function(event, fn) {
        this.listeners[event] = this.getHandler(event, fn);
    }

    GameServer.prototype.getHandler = function(event, fn) {
        switch(event) {
            case 'open':
                return fn;
                break;
            case 'message':
                if(!this.forceAjax) {
                    return function(e) {
                        return fn(JSON.parse(e.data));
                    }
                } else {
                    return fn;
                }
                break;
            case 'close':
                return function() {
                    if (e.readyState == EventSource.CLOSED) {
                        return fn(JSON.parse(e.data));
                    }
                };
                break;
            default:
                return fn;
                break;
        }
    }

    GameServer.prototype.connect = function() {
        if(!!window.EventSource && !this.forceAjax) {
            this.handler = new EventSource(this.url);

            for(var event in this.listeners) {
                this.handler.addEventListener(event, this.listeners[event]);
            }
        } else {
            return bind(this, fetch, this.url)();
        }
    }

    this.GameServer = GameServer;
})(this);

