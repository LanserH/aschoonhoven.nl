<div class="styleFormContactDiv">
        <div class="contactFormDiv">
            <h2>Kom met ons in contact</h2>
            <p>Heeft u een vraag over onze dienstverlening na aanleiding van dit artikel? Neem gerust contact met ons op</p>
        </div>
        <div class="styleFormDiv" id="errorContact">   
            <span class="errorContact" autofocus>
                <?php
                $melding .= "</ol>";
                if ($errorCount == 0) {
                echo "";
                } elseif ($errorCount == 1) {
                    echo "<h2><a href=\"#errorList\">".$errorCount." fout in het contactformulier</a></h2>";
                } else {
                    echo "<h2><a href=\"#errorList\">".$errorCount." fouten in het contactformulier</a></h2>";
                }
                ?>
            </span>
            <span class="errorContactList" id="errorList">
                <?php
                $melding .= "</ol>";
                if($errorCount > 0) {
                    echo $melding;
                }
                ?>
            </span>
        </div>
        <div class="rowContact">
            <div class="columnContact1">
                <div class="cssContactForm">
                    <p>Arjen Schoonhoven</p><br>
                    <a href="&#x6d;&#x61;&#000105;&#x6c;&#000116;&#111;&#x3a;&#x61;&#x72;&#106;&#x65;&#x6e;&#x40;&#97;&#x73;&#x63;&#x68;&#x6f;&#x6f;&#x6e;&#x68;&#111;&#x76;&#000101;&#110;&#x2e;&#110;&#x6c;">arjen@aschoonhoven.nl</a><br>
                    <a href="tel:+31630209619">+31630209619</a>
                </div>
            </div>
            <div class="columnContact2">
                <div class="cssContactForm">                
                    <form name="compForm" method="POST" action="/artikel&id=<?php echo $artikel['ID']?>#errorContact">                     
                    <label class="formLabelContact" for="email">Emailadres:
                        <strong><abbr title="required">*</abbr></strong>
                    </label>
                    <input class="formInput" value="<?php echo $email;?>" type="email" name="email" id="email"/>
                    <label class="formLabelContact" for="vraag">Stel een vraag::
                        <strong><abbr title="required">*</abbr></strong>
                    </label>
                    <textarea class="textAreaContact" name="vraag" id="vraag"><?php echo $vraag;?></textarea>
                    <?php 
                    $$min_number = 1;
                    $max_number = 7;                
                    $random_number1 = mt_rand($min_number, $max_number);
                    $random_number2 = mt_rand($min_number, $max_number);
                    ?>
                    <input name="firstNumber" type="hidden" value="<?php echo $random_number1; ?>" />
                    <input name="secondNumber" type="hidden" value="<?php echo $random_number2; ?>" />
                    <label class="formLabelContact" for="rekenvraag">Rekenvraag: <?php echo $random_number1 . ' + ' . $random_number2 . ' = ';?>
                        <strong><abbr title="required">*</abbr></strong>
                    </label>
                    <input class="formInput" value="<?php echo $rekenvraag;?>" type="number" name="rekenvraag" id="rekenvraag"/>
                    <span>
                    Los de rekensom op en geef de oplossing aan met cijfers. <br>
                    Bijvoorbeeld voor 'drie plus twee = ?' geef een '5' op.
                    </span>                    
                    <input class="formBlueSubmit" type="submit" id="submit" name="submit" value="Verstuur">    
                    </form>  
                </div>
            </div>
        </div>
    </div>