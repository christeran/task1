<?php
/*
 * Initialize variables local
 */
$card1="";
$card2="";
$msg="";
$error=FALSE;

/*
 * Check if the form has been submitted
 */
if (isset($_GET['card1'])&&isset($_GET['card2'])){
    $card1= $_GET['card1'];
    $card2= $_GET['card2'];
    
    if (validation($card1) && validation($card2)){            
        if ($card1==$card2){
            $error=TRUE;
            $msg="You can not enter two card with the same face and suit values ";
        }else{
            //get total score of the user's cards.
            $score=value($card1)+value($card2);
            switch ($score){
            case 22:
                 $error=TRUE;
                 $msg ="Your score is $score. Bust!";
                 break;
            case 21:
                $msg ="Your score a Blackjackt";
                break;
            default :
                $msg ="Your score is $score";
            }            
        }
    }else{
         $error=TRUE;
         $msg="Please enter a correct card format and try again.";
    }
    
}

/*
 * Validate the format of the card:
 * -The first part must have values from 2-10 plus A,K,Q and J (1 or 2 characters)
 * -The Second part must have S,C,D,H (1 character)
 * @param String Card
 * @return boolen messages
 */
function validation ($card){
    $valid_face=array(2,3,4,5,6,7,8,9,10,"J","Q","K","A");
    $valid_suit=array("S","C","D","H");
   
    if ((2!=strlen($card)) && (strlen($card)!=3)){
        return false;
    }
    
    $face= strtoupper(substr_replace($card ,"",-1));    
    
    if (!in_array($face, $valid_face)){
        return FALSE;
    }
    $suit=strtoupper(substr($card, -1));
    if (!in_array($suit, $valid_suit)){
        return FALSE;
    }
    return true;    
}

/*
 * Calculate the value of the card (face):
 * -card from 2-10 being the numeric face value and A is worth 11, K,Q,J is worth 10
 * @param string card
 * @return int value
 */
function value($card){
    $face= strtoupper(substr_replace($card ,"",-1)); 
    if (is_numeric($face))
        return $face;
    
    if($face=="A")
        return 11;
    
    return 10;    
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Blackjack</title>
        <link rel="SHORTCUT ICON" href="media/img/blackjack.ico"/>
        <link rel="apple-touch-icon" href="media/img/blackjack.ico"/>
        <meta name="viewport" content="user-scalable=no, width=device-width, initial-scale=1" />
        <link href="media/css/bootstrap.css" rel="stylesheet" />
    </head>
    <body>    
        <br/>
        <div class="container">            
            <div class="panel panel-primary" style="max-width: 600px; margin-left: auto ; margin-right: auto;">
                <div class="panel-heading">
                    <h3 class="panel-title">Blackjack</h3>
                </div>
                <div class="panel-body">
                    <?php if (!empty($msg)){?>
                        <div class="alert alert-dismissable <?php echo ($error)? "alert-danger":"alert-success" ?>">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong><?php echo ($error)? "Ooppss ":"Congratulations !" ?></strong> <?php echo $msg?>.
                        </div>
                    <?php } ?>
                    <form action="index.php" method="get" >
                        <label>Please enter two cards, using the following format: </label>
                        <ul>
                            <li>The first part of your card must represent the face (values from 2-10 and A, K, Q, J)</li>
                            <li>The second part of your card represents the suit (values S, C, D, H)</li>
                        </ul>
                        <p>Example: AS or 10H</p>
                        <hr/>
                        <div class="row">
                            <div class="col-md-3 col-xs-3 col-sm-3">
                                <div class="form-group">
                                    <label for="card2" class="control-label">First Card</label>                                
                                    <input type="text" class="form-control" name="card1" placeholder="First Card" value="<?php echo $card1?>"  maxlength="3" autocomplete="off">                                
                                </div>
                            </div>
                            <div class="col-md-3 col-xs-3 col-sm-3">
                                <div class="form-group">
                                    <label for="card2" class="control-label">Second Card</label>                                
                                    <input type="text" class="form-control" name="card2" placeholder="Second Card" value="<?php echo $card2?>"  maxlength="3" autocomplete="off">                                
                                </div>
                            </div>
                             <div class="col-md-6 col-xs-6 col-sm-6">
                                 <input type="submit" value="Play" class="btn btn-primary btn" style="margin-top: 25px;"/>
                                 <a onclick="window.location='index.php'" class="btn btn-default pull-right " style="margin-top: 25px;">Play again</a>
                            </div>
                        </div>  
                    </form>
                </div>            
            </div>
        </div>
        <script src="media/js/bootstrap.min.js"></script>   
    </body>
</html>
