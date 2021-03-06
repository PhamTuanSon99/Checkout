define(
    [
        'jquery',
        'ko',
        'uiComponent',
        'underscore',
        'mage/url',
        'mage/storage',
        'Magento_Checkout/js/model/step-navigator',
        'Magento_Customer/js/model/customer'
    ],
    function (
        $,
        ko,
        Component,
        _,
        urlBuilder,
        storage,
        stepNavigator,
        customer
    ) {
        'use strict';
        /**
        * check-login - is the name of the component's .html template
        */
        return Component.extend({
            defaults: {
                template: 'AHT_Checkout/check-login'
            },

            //add here your logic to display step,
            isVisible: ko.observable(true),
            isLogedIn: customer.isLoggedIn(),
            //step code will be used as step content id in the component template
            stepCode: 'delivery',
            //step title value
            stepTitle: 'Delivery Step',

            /**
            *
            * @returns {*}
            */
            initialize: function () {
                this._super();
                // register your step
                stepNavigator.registerStep(
                    this.stepCode,
                    //step alias
                    null,
                    this.stepTitle,
                    //observable property with logic when display step or hide step
                    this.isVisible,

                    _.bind(this.navigate, this),

                    /**
                    * sort order value
                    * 'sort order value' < 10: step displays before shipping step;
                    * 10 < 'sort order value' < 20 : step displays between shipping and payment step
                    * 'sort order value' > 20 : step displays after payment step
                    */
                    15
                );

                return this;
            },

            /**
            * The navigate() method is responsible for navigation between checkout step
            * during checkout. You can add custom logic, for example some conditions
            * for switching to your custom step
            */
            navigate: function () {
                this.isVisible(true);
            },

            /**
            * @returns void
            */
            navigateToNextStep: function () {
                //get data
                var date = $(".delivery_date").val();
                var comment = $(".delivery_comment").val();

                //set URL
                //frontName->Controller->Action
                var url = urlBuilder.build('delivery/index/savedata');

                return storage.post(
                    url,
                    JSON.stringify({ date: date, comment: comment }), //convert json to string
                    false
                ).done(function (response) {
                    //get to the next step
                    console.log(response);
                    stepNavigator.next();
                }).fail(function () {
                    //log data
                    console.log(date);
                    console.log(comment);
                });
            }
        });
    }
);