/* =============================================================================
 *
 * Bootstrap Extra v1.1.0
 * http://tonystar.ru/projects/bootstrap-extra
 *
 * -----------------------------------------------------------------------------
 *
 * The MIT License (MIT)
 *
 * Copyright (c) 2013 Anton Staroverov
 * http://tonystar.ru
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * ========================================================================== */


+function ($) { "use strict";

  // PIN CLASS DEFINITION
  // ====================

  var Pin = function (element, options) {
    this.options = $.extend({}, Pin.DEFAULTS, options)
    this.$window = $(window)
      .on('resize.bs.pin.data-api', $.proxy(this.checkOffsets, this))
      .on('scroll.bs.pin.data-api', $.proxy(this.checkPosition, this))

    this.$element = $(element).wrap('<div>')
    this.$container = $(options.container).css('position', 'relative')
    this.spacing = (this.$container.outerHeight() - this.$container.height()) / 2
    this.pinned = false

    this.uid = 'id-' + Math.random().toString(36).substr(2, 9)
    this.$element.addClass(this.uid)
    this.$style = $('<style>')
    $('head').append(this.$style)

    this.checkOffsets()
    this.checkPosition()
  }

  Pin.RESET = 'pin pin-top pin-bottom'

  Pin.DEFAULTS = {
    container: 'body'
  }

  Pin.prototype.checkOffsets = function () {
    // Set the proper width to the element:
    this.$element.width(this.$element.parent().width())

    // Set proper margins for the pinned element:
    this.$style.html([
      '.' + this.uid + '.pin { top: ' + this.spacing + 'px }'
    , '.' + this.uid + '.pin-bottom { bottom: ' + this.spacing + 'px }'
    ].join('\n'))

    this.minOffset = this.$element.parent().offset().top - this.spacing
    this.maxOffset = this.$container.offset().top + this.$container.height() - this.$element.height()
  }

  Pin.prototype.checkPosition = function () {
    if (!this.$element.is(':visible')) return

    var currentOffset = this.$window.scrollTop()

    var pin = currentOffset < this.minOffset ? 'top' :
              currentOffset < this.maxOffset ? false : 'bottom'

    if (this.pinned == pin) return

    this.pinned = pin

    this.$element.removeClass(Pin.RESET).addClass('pin' + (pin ? '-' + pin : ''))
  }


  // PIN PLUGIN DEFINITION
  // =====================

  var old = $.fn.pin

  $.fn.pin = function (options) {
    return this.each(function () {
      var $this = $(this)
      var data  = $this.data('bs.pin')

      if (!data) $this.data('bs.pin', (data = new Pin(this, options)))
    })
  }

  $.fn.pin.Constructor = Pin


  // PIN NO CONFLICT
  // ===============

  $.fn.pin.noConflict = function () {
    $.fn.pin = old
    return this
  }


  // PIN DATA-API
  // ============

  $(window).on('load', function () {
    $('[data-spy="pin"]').each(function () {
      var $this = $(this)
      var data = $this.data()

      $this.pin(data)
    })
  })

}(jQuery);
