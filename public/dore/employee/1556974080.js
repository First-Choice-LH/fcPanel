/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * @api
 */
define([
    'jquery',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/model/url-builder',
    'Hashcrypt_Devs/js/model/customer',
    'Magento_Checkout/js/model/place-order'
], function ($, quote, urlBuilder, customer, placeOrderService) {
    'use strict';

    return function (paymentData, messageContainer) {
        var serviceUrl, payload;

        payload = {
            cartId: quote.getQuoteId(),
            billingAddress: quote.billingAddress(),
            paymentMethod: paymentData
        };

        // MODIFICATION START + jquery added as dependency
            var additionalData = {extension_attributes: {}};
            //console.log('place-order js');
            //console.log(payload.billingAddress);
            if (payload.billingAddress.barangay !== undefined) {
                additionalData.extension_attributes.barangay = payload.billingAddress.barangay;
                delete payload.billingAddress.barangay;
            }
            payload.billingAddress = $.extend(payload.billingAddress, additionalData);
        // MODIFICATION END

        if (customer.isLoggedIn()) {
            serviceUrl = urlBuilder.createUrl('/carts/mine/payment-information', {});
        } else {
            serviceUrl = urlBuilder.createUrl('/guest-carts/:quoteId/payment-information', {
                quoteId: quote.getQuoteId()
            });
            payload.email = quote.guestEmail;
        }

        return placeOrderService(serviceUrl, payload, messageContainer);
    };
});
