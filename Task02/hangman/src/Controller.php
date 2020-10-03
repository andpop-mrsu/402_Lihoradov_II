<?php
	namespace IvanLikhoradov\hangman\Controller;
	use function IvanLikhoradov\hangman\View\viewGame;
	
	function startGame(){
		echo "Start\n";
		viewGame();
	}

?>
