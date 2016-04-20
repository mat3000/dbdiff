/*! 
* plugin v0.1.0
* http://mathieu-bruno.com
* Copyright 2015, Mathieu BRUNO
*/

(function ( $, window, document, undefined ) {

    function myplugin(element, options) {

///// GLOBALS /////
        var self = this;
        self.options = $.extend( {}, defaults, options);

        self.$el = $(element);

///// INIT /////
        self._init();

    };

    myplugin.prototype = {

        _init : function(){

            var self = this;

            self.template();

        },

        template : function(){

            var self = this;

            self.$el
            self.options.test;

        }

    };

    $.fn.rSlider = function ( options ) {
        return this.each(function () {
            if (!$.data(this, 'rSlider')) {
                $.data(this, 'rSlider', 
                new myplugin( this, options ));
            };
        });
    };

    var defaults = {

        test : null

    };

})( jQuery, window, document );