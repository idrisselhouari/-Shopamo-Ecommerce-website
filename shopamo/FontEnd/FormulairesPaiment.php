            <div class="methodePaiement" >
                        <label for="cb">Carte Bancaire<input type="radio" id="cb" name="paiement" class="paiement" onclick="afficheFormCB()"></label>
                        <label for="pp">Paypal<input type="radio" id="pp" name="paiement" class="paiement" onclick="afficheFormPP()"></label>
                        <label for="pl">Paiement à la livraison<input type="radio" id="pl" name="paiement" class="paiement" onclick="afficheFormPL()" ></label>
                        <div class="formulairePaiement" style="margin: 5% 0 5% 0;">
                    <form action="" id="formPP" class="formPaiment">
                        <input type="text" placeholder="Nom complet" class="memeLigne">
                        <input type="tel" placeholder="Telephone" class="memeLigne">
                        <input type="text" placeholder="Ville" class="memeLigne"> 
                        <input type="text" placeholder="Adresse" class="memeLigne">
                        <div id="paypal-button-container"></div>
                        <div class="buttonPaiement">
                            <input type="submit" class="btn" value="Valider">
                            <input type="reset" class="btn" value="Annuler">
                        </div>
                    </form>
                    <form action="Panier/paiment.php" method="post" id="formCB" class="formPaiment">
                        <input type="text" placeholder="Nom complet"  name="NomComplet" class="memeLigne" required>
                        <input type="tel" placeholder="Telephone" name="Telephone" class="memeLigne" pattern="[0-9]{10}" required>
                        <input type="text" placeholder="Ville" name="Ville" class="memeLigne" required> 
                        <input type="text" placeholder="Adresse" name="Adresse" class="memeLigne" required>
                        <input type="text" placeholder="Numéro de la carte bancaire" name="NumeroCarte" class="memeLigne" pattern="[0-9]{16}" required>
                        <input type="text" placeholder="Nom de propriétère" name="NomProprietere" class="memeLigne" required>
                        <input type="datetime" placeholder="Date d'experation" name="DateExperation" class="memeLigne" required>
                        <input type="text" placeholder="CCV" name="CCV" class="memeLigne" pattern="[0-9]{3}" required>
                        <div class="buttonPaiement">
                            <input type="submit" class="btn" name="validerCB" value="Valider">
                            <input type="reset" class="btn" value="Annuler">
                        </div>
                    </form>
                    <form action="Panier/paiment.php" method="post" id="formPL" class="formPaiment">
                        <input type="text" placeholder="Nom complet" name="NomComplet" class="memeLigne" required>
                        <input type="tel" placeholder="Telephone" name="Telephone" class="memeLigne" pattern="[0-9]{10}" required>
                        <input type="text" placeholder="Ville" name="Ville" class="memeLigne" required> 
                        <input type="text" placeholder="Adresse" name="Adresse" class="memeLigne" required>
                        <div class="buttonPaiement">
                            <input type="submit" name="validerPL" class="btn" value="Valider">
                            <input type="reset" class="btn" value="Annuler">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> 
    </main> 
    <!--For the paypal methode-->
    <script>
            paypal.Buttons({
            style: {
            layout:  'horizontal',
            color:   'white',
            shape:   'pill',
            },

            // Sets up the transaction when a payment button is clicked
            createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                amount: {
                    value: "<?php echo $data['productPrincipalPrice'];?>"// Can reference variables or functions. Example: `value: document.getElementById('...').value`
                }
                }]
            });
            },
            // Finalize the transaction after payer approval
            onApprove: function(data, actions) {
            return actions.order.capture().then(function(orderData) {
                // Successful capture! For dev/demo purposes:
                    console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                    var transaction = orderData.purchase_units[0].payments.captures[0];
                    alert('Transaction '+ transaction.status + ': ' + transaction.id + '\n\nSee console for all available details');

                // When ready to go live, remove the alert and show a success message within this page. For example:
                // var element = document.getElementById('paypal-button-container');
                // element.innerHTML = '';
                // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                // Or go to another URL:  actions.redirect('thank_you.html');
            });
        }
        }).render('#paypal-button-container');
    </script>
    <!--**********************-->