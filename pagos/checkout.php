<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://www.paypal.com/sdk/js?client-id=Acn4fC_7PyQfbDIOJQqlIhsEH4SakZ3x8kM9dZnh-yEFyDstQNJ5giif3z0u36S8ESCbJrrXY__NUQlM&currency=MXN"></script>
    <!-- Set up a container element for the button -->

</head>
<body>
  <center>

  <div id="paypal-button-container"></div>
    <script>
      paypal.Buttons({

        // Sets up the transaction when a payment button is clicked
        createOrder: (data, actions) => {
          return actions.order.create({
            purchase_units: [{
              amount: {
                value: '77.44' // Can also reference a variable or function
              }
            }]
          });
        },
        // Finalize the transaction after payer approval
        onApprove: (data, actions) => {
          return actions.order.capture().then(function(orderData) {
            // Successful capture! For dev/demo purposes:
            console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
            const transaction = orderData.purchase_units[0].payments.captures[0];
            alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`);
            // When ready to go live, remove the alert and show a success message within this page. For example:
            // const element = document.getElementById('paypal-button-container');
            // element.innerHTML = '<h3>Thank you for your payment!</h3>';
            // Or go to another URL:  actions.redirect('thank_you.html');
          });
        },
        style:{
        color:'black',
        shape: 'pill',
        label: 'pay'
        },
        onApprove: function(data, actions){
            actions.order.capture().then(function(detalles){
                window.location.href="completado.html";
            });
        },
        onCancel: function(data){
            alert("Pago cancelado");
            concole.log(data);
        }
        }).render('#paypal-button-container');
    </script>

  </center>
</body>
</html>