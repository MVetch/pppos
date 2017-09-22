<?//$db->ListAllQueries()?>					
					<!-- <?if($showMenu):?> -->
	                    	</div>
						</div>
					<!-- <?endif?> -->
            	</div><!-- end row -->
            </div><!-- end container -->
    	</section> <!--end service-row -->
        <?$page_load = isset($page_start)?(microtime(true) - $page_start):-1?>
        <div class="footer-credit"> <b>ПРИ ПОДДЕРЖКЕ <a href="/contact">ПРОФБЮРО ФАИ</a></b> <?=$db->queriesCount?> запросов за <?=round($db->executionTime,5)?> секунд, страница за <?=round($page_load,5)?></div>
        <script type="text/javascript" src="/js/formHandler.js"></script>
        <?file_put_contents($_SERVER['DOCUMENT_ROOT']."/data.csv", $db->queriesCount.';'.round($db->executionTime,5).';'.round($page_load,5).';'.$_SERVER['PHP_SELF'].';'.(isset($user)?$user->getId():'0').';'.(isset($user)?$user->getLevel():'0')."\n", FILE_APPEND)?>
    </body>
</html>