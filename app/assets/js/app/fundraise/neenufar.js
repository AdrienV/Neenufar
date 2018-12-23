$(document).ready(function () {
    $('#fund').click(function () {
        app.fund();
    });

    $('#fundraiseNow').click(function () {
        app.fund();
    });

    app.getCurrency();
});

app = {
    getCurrency: function () {
        $.ajax({
            type: 'GET',
            url: $('#base_url').val() + 'ajax/getCurrency/ethereum/usd',
            cache: false,
            dataType: 'json',
            success: function (currency) {
                console.log(currency);
                if (currency.status == 'success' || currency.status == 'success_api') {
                    $('.priceUsd').html('(~' + parseInt(currency.value * $('.amountEth').html()) + ' USD)');
                    $('.priceRaisedUsd').html('(~' + parseInt(currency.value * $('.amountRaisedEth').html()) + ' USD)');
                }
            }
        });
    },
    fund: function () {
        if (typeof web3 !== 'undefined') {
            web3 = new Web3(web3.currentProvider);
        } else {
            // Set the provider you want from Web3.providers
            web3 = new Web3(new Web3.providers.HttpProvider("http://www.neenufar.com"));
        }
        if (typeof web3 !== 'undefined') {
            console.log('Web3 Detected! ' + web3.currentProvider.constructor.name);
            if (web3.currentProvider.constructor.name != 's') {
                window.web3 = new Web3(web3.currentProvider);

                if ($('#c1').is(':checked')) {
                    value = 0.5;
                }
                if ($('#c2').is(':checked')) {
                    value = 1;
                }
                if ($('#c3').is(':checked')) {
                    value = 2;
                }
                if ($('#cshark').val() != '') {
                    value = $('#cshark').val();
                }

                var toAddress = '0x43432f31ad7BB08DC84888B1e8CedB582cC3cdE4';
                var ethAmount = value.toString();

                $('#output').hide();
                web3.eth.getAccounts()
                        .then(accounts => {
                            if (accounts.length > 0) {
                                web3.eth.sendTransaction({
                                    from: accounts[0],
                                    to: toAddress,
                                    value: web3.utils.toWei(ethAmount, 'ether')
                                }, function (error, result) {
                                    if (error) {
                                        $('#output').html('Something went wrong!');
                                        $('#output').show();
                                    } else {
                                        $('#output').html("Track the payment: <a href='https://etherscan.io/tx/" + result + "'>https://etherscan.io/tx/" + result + "'");
                                        $('#output').show();
                                    }
                                });
                            } else {
                                $('#output').html('Please connect your account on Metamask extension : <a href="https://metamask.io/">https://metamask.io/</a>');
                                $('#output').show();
                            }
                        }
                        );
            } else {
                $('#output').html('Please download and install Metamask: <a href="https://metamask.io/">https://metamask.io/</a>');
                $('#output').show();
            }
        } else {
            $('#output').html('Please download and install Metamask: <a href="https://metamask.io/">https://metamask.io/</a>');
            $('#output').show();
        }
    }
}