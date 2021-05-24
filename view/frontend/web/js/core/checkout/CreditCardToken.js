var CreditCardToken = function (formObject, documentNumber = null) {
    this.documentNumber = documentNumber;
    if (documentNumber != null) {
        this.documentNumber = documentNumber.replace(/(\.|\/|\-)/g,"");
    }
    this.formObject = formObject;
};

CreditCardToken.prototype.getDataToGenerateToken = function () {
    return {
        type: "card",
        card : {
            holder_name: this.formObject.creditCardHolderName.val(),
            number: this.formObject.creditCardNumber.val(),
            exp_month: this.formObject.creditCardExpMonth.val(),
            exp_year: this.formObject.creditCardExpYear.val(),
            cvv: this.formObject.creditCardCvv.val(),
            holder_document: this.documentNumber
        }
    };
}

CreditCardToken.prototype.getToken = function (pkKey, isHubEnabled) {
    var data = this.getDataToGenerateToken();

    // TODO: THIS MUST BE REMOVED WHEN WE START USING PRODUCTION HUB!
    const url = isHubEnabled ?
        'https://stgapi.mundipagg.com/core/v1/tokens?appId=' :
        'https://api.mundipagg.com/core/v1/tokens?appId=';

    return jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: url + pkKey,
        async: false,
        cache: true,
        data
    });
}
