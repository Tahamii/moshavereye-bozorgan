<?php
$question = '';
$msg = "سوال خود را بپرس!";

$text=fopen("messages.txt","r");
$js = file_get_contents('people.json');
$names = json_decode($js,true);

$q=0;
while (! feof($text))
{
    $arr_jomle[$q] = fgets($text);
    $q++;
}

$en_name = array_rand($names);
if(isset($_POST["person"])){
    $en_name = $_POST["person"];
}
$fa_name = $names[$en_name];

if(isset($_POST["question"])){
	$question = $_POST["question"];
	$msg = $arr_jomle[intval(hash('gost', $question.$en_name))%16];
	if(substr($question, 0, 6)!="آیا" ){// for PHP 8.0 and higher we could add : (|| str_ends_with($question,"?")==0 || str_ends_with($question,"؟")==0) but for me it didn't work.
		$msg = "سوال درستی پرسیده نشده";
	}
}
	#$msg = array_rand($arr_jomle[]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="styles/default.css">
    <title>مشاوره بزرگان</title>
</head>
<body>
<p id="copyright">تهیه شده برای درس کارگاه کامپیوتر،دانشکده کامییوتر، دانشگاه صنعتی شریف</p>
<div id="wrapper">
    <div id="title">
        <span id="label">
		<?php
                	if($question != ""){
                    		echo "پرسش:";
                	}
		?>
		</span>
        <span id="question"><?php echo $question ?></span>
    </div>
    <div id="container">
        <div id="message">
            <p>
		<?php 
			if ($question != ""){
				echo $msg;
			}
			else{
				echo "سوال خود را بپرس!";
			}
		?>
	</p>
        </div>
        <div id="person">
            <div id="person">
                <img src="images/people/<?php echo "$en_name.jpg" ?>"/>
                <p id="person-name"><?php echo $fa_name ?></p>
            </div>
        </div>
    </div>
    <div id="new-q">
        <form method="post">
            سوال
            <input type="text" name="question" value="<?php echo $question ?>" maxlength="150" placeholder="..."/>
            را از
            <select name="person">
                <?php
			$js = file_get_contents('people.json');
			$arr_name=json_decode($js,true);
                   	 foreach ($arr_name as $key => $val){
                       		if ($key==$en_name){
					echo "<option value=$key selected> $val</option>";
                        	}
                       		else{
					echo "<option value=$key > $val</option>";
                      		 }
                    	}
                ?>
            </select>
            <input type="submit" value="بپرس"/>
        </form>
    </div>
</div>
</body>
</html>
