<?php

# Check was this fil linked directly
if(!defined('SYSPATH')) exit('No direct script access allowed!');

?>
				<div id="topQuotes">
					<h2>Funny quotes</h2>
				</div>
				<div class="mainContent">
					<blockquote>
						<p>&ldquo; <?php echo $quoter->readQuotesFromFile(); ?> &rdquo;</p>
					</blockquote>
				</div>