(function(shoptet) {
    var myCustomRuntimeObject = {};
    myCustomRuntimeObject.updated = false;
    // create content of modal
    var modalContent = document.createElement('div');
    var link = document.createElement('a');
    link.innerText = 'My custom link text';
    link.addEventListener('click', function (e) {
        e.preventDefault();
        // do all your necessary stuff here
        myCustomRuntimeObject.branchId = Math.ceil(Math.random(2) * 10);
        myCustomRuntimeObject.label =
            'Label of branch' + myCustomRuntimeObject.branchId;
        myCustomRuntimeObject.price = {
            withVat: 100,
            withoutVat: 82.64
        };
        // mark change of shipping here
        myCustomRuntimeObject.updated = true;
        shoptet.modal.close();
    });
    modalContent.appendChild(link);

    // do not ever rewrite shoptet nor shoptet.externalShipping object
    shoptet.externalShipping = shoptet.externalShipping || {};
    // `externalShippingOne` - required shipping name in camelCase
    // must be identical as code of external shipping
    shoptet.externalShipping.externalShippingOne = {
        modalContent: modalContent,
        onComplete: function(el) {
            // code executed after the modal is fully loaded
            // you have access to element containing your shipping method details
            console.log(el);
            // shoptet.modal.resize() has to be the last called function
            shoptet.modal.resize();
        },
        onClosed: function(el) {
            if (myCustomRuntimeObject.updated) {
                // set all necessary details about shipping
                // and fire event to update prices and labels in checkout
                var ev = new CustomEvent(
                    'ShoptetExternalShippingChanged',
                    {
                        detail: {
                            price: myCustomRuntimeObject.price,
                            branch: {
                                id: myCustomRuntimeObject.branchId,
                                label: myCustomRuntimeObject.label
                            }
                        }
                    }
                );
                el.dispatchEvent(ev);
                myCustomRuntimeObject.updated = false;
            }
        }
    };
    // parameters modalContent, onComplete and onClosed are required
    // optionally you can use also modalWidth and modalClass parameters
    // default values are shoptet.modal.config.widthMd and shoptet.modal.config.classMd
})(shoptet);
