jQuery(document).ready(function($) {
    function debounce(func, wait) {
        var timeout;
        return function() {
            var context = this, args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                func.apply(context, args);
            }, wait);
        };
    }

function dqfwc_updateQuantity() {
    try {
        $('.product .quantity:visible, .woocommerce-cart-form__cart-item .quantity:visible').each(function() {
            var $this = $(this),
                $input = $this.find('.qty'),
                $plus = $this.find('.plus'),
                $minus = $this.find('.minus');
			
			var isIntegerQuantity = $this.closest('.product, .woocommerce-cart-form__cart-item').hasClass('integer-quantity');
			
            function refreshQty() {
                var qty = parseFloat($input.val()),
                    min = parseFloat($input.attr('min')),
                    max = parseFloat($input.attr('max')),
                    step = parseFloat($input.attr('step'));

                if (isNaN(qty) || qty < 1) qty = 0;
                if (isNaN(min)) min = 0;
                if (isNaN(max)) max = '';
                if (isNaN(step)) step = isIntegerQuantity ? 1 : 0.1;

                return { qty, min, max, step, isIntegerQuantity };
            }
			
			function formatQuantity(qty) {
                return isIntegerQuantity ? Math.floor(qty) : qty.toFixed(1);
            }

            function updateInputValue(newQty) {
                $input.val(formatQuantity(newQty)).trigger('change');
            }
			
            var qtyData = refreshQty();
			
            $plus.off('click').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                qtyData = refreshQty(); // Get updated value
                if (qtyData.max && (qtyData.qty >= qtyData.max)) {
                    console.log('Max reached');
                    return;
                }
              
                var newQty;
                if (isIntegerQuantity) {
                    newQty = Math.min(qtyData.max || Infinity, Math.floor(qtyData.qty + qtyData.step));
                } else {
                    newQty = Math.min(qtyData.max || Infinity, (Math.round((qtyData.qty + qtyData.step) * 10) / 10));
                }
                updateInputValue(newQty);
            }).attr('aria-label', 'Augmenter la quantité');

			
            $minus.off('click').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                qtyData = refreshQty(); // Get updated value
                if (qtyData.qty <= qtyData.min) return;
				var newQty;
                if (isIntegerQuantity) {
                    newQty = Math.max(qtyData.min, Math.floor(qtyData.qty - qtyData.step));
                } else {
                    newQty = Math.max(qtyData.min, (Math.round((qtyData.qty - qtyData.step) * 10) / 10));
                }
                updateInputValue(newQty);
            }).attr('aria-label', 'Diminuer la quantité');
        });
    } catch (error) {
        console.error('Error in updateQuantity:', error);
    }
}


    var debouncedUpdateQuantity = debounce(dqfwc_updateQuantity, 250);

    $(document).on('updated_cart_totals', debouncedUpdateQuantity);
    $(document).on('found_variation', debouncedUpdateQuantity);
    debouncedUpdateQuantity();

    var observer = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
        if (mutation.type === 'childList' && 
            (mutation.target.closest('.product') || mutation.target.closest('.woocommerce-cart-form'))) {
            debouncedUpdateQuantity();
        }
    });
});

observer.observe(document.body, { childList: true, subtree: true });
});

