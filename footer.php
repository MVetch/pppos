<?//$db->ListAllQueries()?>					
	                    	</div>
						</div>
            	</div><!-- end row -->
            </div><!-- end container -->
    	</section> <!--end service-row -->
        <?$page_load = isset($page_start)?(microtime(true) - $page_start):-1?>
        <div class="footer-credit"> <b>ПРИ ПОДДЕРЖКЕ <a href="/contact">ПРОФБЮРО ФАИ</a></b></div>
        <script type="text/javascript" src="/js/formHandler.js"></script>
        <?file_put_contents($_SERVER['DOCUMENT_ROOT']."/data.csv", $db->queriesCount.';'.round($db->executionTime,5).';'.round($page_load,5).';'.$_SERVER['PHP_SELF'].';'.(isset($user)?$user->getId():'0').';'.(isset($user)?$user->getLevel():'0').';'.date("H:i:s d.m.Y")."\n", FILE_APPEND)?>
    </body>
</html>