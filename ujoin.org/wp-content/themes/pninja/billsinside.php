<?php
/*
Template Name: Bills Inside
*/
?>

<?php get_header() ?>

	<?php if ( is_user_logged_in() ) { ?>

<div id="content-page">              

		<div id="contentLeft">
        	
            <span class="contentLeftTitle"><span>Strong opposition to Bill 25 CD1 Raising Waikiki Parking Meter Fees</span></span>
            <ul>
            	<li><a href="#">Add Update</a></li>
            	<li><a href="#">Edit Bill</a></li>
            	<li><a href="#">Delete Bill</a></li>                                                                    
                <li><a href="#" class="linkless"><img src="<?php bloginfo('stylesheet_directory') ?>/images/bg-leftbottombig.png" /></a></li>
            </ul>
            
        </div>
        
   <div id="contentRight">
        
        	<div id="contentRightTop">
                
                <div id="main">
                
                	<h1>Edit Bill</h1>      
                    <p>Some text talking about the edit page...</p>                                                
                        
                  <ul id="newBill" style="padding:4px 0 0;">
                        <li>
                          <label class="labelLeft">Position Statement:</label>
                          <select>
                            <option>Strong support for</option>
                            <option>Strong opposition to</option>
                          </select>
                        </li>                      

                        <li><label class="labelLeft">Name of Bill</label><input type="text" size="40" class="text"></li>
                        <li><label class="labelLeft">Date</label><input type="text" size="40" class="text"></li>
                        <li><label class="labelLeft">URL</label><input type="text" size="40" class="text"></li>
                        <li><label class="labelLeft">RSS update URL</label><input type="text" size="40" class="text"></li>
                        <li>
                          <label class="labelLeft">Chair:</label>
                          	<select>
                                <optgroup label="None"><option value="">N/A</option></optgroup><optgroup label="Representatives"><option value="0">Henry J.C. Aquino</option>
                                <option value="1">Karen Leilani Awana</option>
                                <option value="2">Della Au Belatti</option>
                                <option value="3">Lyla B Berg, PhD</option>
                                <option value="4">Joe Bertram III</option>
                                <option value="5">Tom Brower</option>
                                <option value="6">Rida T.R. Cabanilla</option>
                                <option value="7">Mele Carroll</option>
                                <option value="8">Jerry L. Chang</option>
                                <option value="9">Corinne W.L. Ching</option>
                                <option value="10">Pono Chong</option>
                                <option value="11">Isaac Choy</option>
                                <option value="12">Denny Coffman</option>
                                <option value="13">Cindy Evans</option>
                                <option value="14">Lynn Finnegan</option>
                                <option value="15">Faye P. Hanohano</option>
                                <option value="16">Sharon E. Har</option>
                                <option value="17">Robert N. Herkes</option>
                                <option value="18">Ken Ito</option>
                                <option value="19">Jon Riki Karamatsu</option>
                                <option value="20">Chris Lee</option>
                                <option value="21">Marilyn B. Lee</option>
                                <option value="22">Sylvia Luke</option>
                                <option value="23">Michael Y. Magaoay</option>
                                <option value="24">Joey Manahan</option>
                                <option value="25">Barbara C. Marumoto</option>
                                <option value="26">Angus L.K. McKelvey</option>
                                <option value="27">John Mizuno</option>
                                <option value="28">Hermina M. Morita</option>
                                <option value="29">Mark M. Nakashima</option>
                                <option value="30">Bob Nakasone</option>
                                <option value="31">Scott Y. Nishimoto</option>
                                <option value="32">Blake K. Oshiro</option>
                                <option value="33">Marcus R. Oshiro</option>
                                <option value="34">Kymberly Marcos Pine</option>
                                <option value="35">Karl Rhoads</option>
                                <option value="36">Roland D. Sagum III</option>
                                <option value="37">Scott K. Saiki</option>
                                <option value="38">Calvin K.Y. Say</option>
                                <option value="39">Maile S.L. Shimabukuro</option>
                                <option value="40">Joseph M. Souki</option>
                                <option value="41">Mark K. Takai</option>
                                <option value="42">Roy M. Takumi</option>
                                <option value="43">Cynthia Thielen</option>
                                <option value="44">James Kunane Tokioka</option>
                                <option value="45">Clift Tsuji</option>
                                <option value="46">Glen Wakai</option>
                                <option value="47">Gene Ward Ph.D.</option>
                                <option value="48">Jessica Wooley</option>
                                <option value="49">Ryan I. Yamane</option>
                                <option value="50">Kyle T. Yamashita</option></optgroup><optgroup label="Senators"><option value="51">Rosalyn H. Baker</option>
                                <option value="52">J. Kalani English</option>
                                <option value="53">Will Espero</option>
                                <option value="54">Carol Fukunaga</option>
                                <option value="55">Mike Gabbard</option>
                                <option value="56">Clayton Hee</option>
                                <option value="57">David Y. Ige</option>
                                <option value="58">Donna Mercado Kim</option>
                                <option value="59">Clarence Nishihara</option>
                                <option value="60">Suzanne Chun Oakland</option>
                                <option value="61">Norman Sakamoto</option>
                                <option value="62">Dwight Y. Takamine</option>
                                <option value="63">Brian T. Taniguchi</option>
                                <option value="64">Jill S. Tokuda</option></optgroup><optgroup label="Honolulu/Oahu County"><option value="89">Todd K. Apo</option>
                                <option value="90">Duke Bainum</option>
                                <option value="91">Romy M. Cachola</option>
                                <option value="92">Donavan M. Dela Cruz</option>
                                <option value="93">Charles K. Djou</option>
                                <option value="94">Nestor R. Garcia</option>
                                <option value="95">Barbara Marshall</option>
                                <option value="96">Gary H. Okino</option>
                                <option value="97">Rod Tam</option></optgroup><optgroup label="Maui County"><option value="81">Gladys Coelho Baisa</option>
                                <option value="82">Jo Anne Johnson</option>
                                <option value="83">Sol Kahoohalahala</option>
                                <option value="84">Danny A. Mateo</option>
                                <option value="85">Bill Kauakea Medeiros</option>
                                <option value="86">Michael J. Molina</option>
                                <option value="87">Joseph.Pontanilla</option>
                                <option value="88">Michael P. Victorino</option></optgroup><optgroup label="Hawaii County"><option value="65">Guy Enriques</option>
                                <option value="66">Brenda Ford</option>
                                <option value="67">Kelly Greenwell</option>
                                <option value="68">Donald Ikeda</option>
                                <option value="69">Pete Hoffmann</option>
                                <option value="70">Dennis Onishi</option>
                                <option value="71">Emily I. Naeole</option>
                                <option value="72">Dominic Yagong</option>
                                <option value="73">J Yoshimoto</option></optgroup><optgroup label="Kauai County"><option value="74">William Kaipo Asing</option>
                                <option value="75">Tim Bynum</option>
                                <option value="76">Vickie Chang</option>
                                <option value="77">Jay Furfaro</option>
                                <option value="78">Daryl W. Kaneshiro</option>
                                <option value="79">Lani Kawahara</option>
                                <option value="80">Derek Kawakami</option></optgroup>
                          </select>
                        </li>  
                        <li>
                          <label class="labelLeft">Vice Chair:</label>
                          <select>
                                <optgroup label="None"><option value="">N/A</option></optgroup><optgroup label="Representatives"><option value="0">Henry J.C. Aquino</option>
                                <option value="1">Karen Leilani Awana</option>
                                <option value="2">Della Au Belatti</option>
                                <option value="3">Lyla B Berg, PhD</option>
                                <option value="4">Joe Bertram III</option>
                                <option value="5">Tom Brower</option>
                                <option value="6">Rida T.R. Cabanilla</option>
                                <option value="7">Mele Carroll</option>
                                <option value="8">Jerry L. Chang</option>
                                <option value="9">Corinne W.L. Ching</option>
                                <option value="10">Pono Chong</option>
                                <option value="11">Isaac Choy</option>
                                <option value="12">Denny Coffman</option>
                                <option value="13">Cindy Evans</option>
                                <option value="14">Lynn Finnegan</option>
                                <option value="15">Faye P. Hanohano</option>
                                <option value="16">Sharon E. Har</option>
                                <option value="17">Robert N. Herkes</option>
                                <option value="18">Ken Ito</option>
                                <option value="19">Jon Riki Karamatsu</option>
                                <option value="20">Chris Lee</option>
                                <option value="21">Marilyn B. Lee</option>
                                <option value="22">Sylvia Luke</option>
                                <option value="23">Michael Y. Magaoay</option>
                                <option value="24">Joey Manahan</option>
                                <option value="25">Barbara C. Marumoto</option>
                                <option value="26">Angus L.K. McKelvey</option>
                                <option value="27">John Mizuno</option>
                                <option value="28">Hermina M. Morita</option>
                                <option value="29">Mark M. Nakashima</option>
                                <option value="30">Bob Nakasone</option>
                                <option value="31">Scott Y. Nishimoto</option>
                                <option value="32">Blake K. Oshiro</option>
                                <option value="33">Marcus R. Oshiro</option>
                                <option value="34">Kymberly Marcos Pine</option>
                                <option value="35">Karl Rhoads</option>
                                <option value="36">Roland D. Sagum III</option>
                                <option value="37">Scott K. Saiki</option>
                                <option value="38">Calvin K.Y. Say</option>
                                <option value="39">Maile S.L. Shimabukuro</option>
                                <option value="40">Joseph M. Souki</option>
                                <option value="41">Mark K. Takai</option>
                                <option value="42">Roy M. Takumi</option>
                                <option value="43">Cynthia Thielen</option>
                                <option value="44">James Kunane Tokioka</option>
                                <option value="45">Clift Tsuji</option>
                                <option value="46">Glen Wakai</option>
                                <option value="47">Gene Ward Ph.D.</option>
                                <option value="48">Jessica Wooley</option>
                                <option value="49">Ryan I. Yamane</option>
                                <option value="50">Kyle T. Yamashita</option></optgroup><optgroup label="Senators"><option value="51">Rosalyn H. Baker</option>
                                <option value="52">J. Kalani English</option>
                                <option value="53">Will Espero</option>
                                <option value="54">Carol Fukunaga</option>
                                <option value="55">Mike Gabbard</option>
                                <option value="56">Clayton Hee</option>
                                <option value="57">David Y. Ige</option>
                                <option value="58">Donna Mercado Kim</option>
                                <option value="59">Clarence Nishihara</option>
                                <option value="60">Suzanne Chun Oakland</option>
                                <option value="61">Norman Sakamoto</option>
                                <option value="62">Dwight Y. Takamine</option>
                                <option value="63">Brian T. Taniguchi</option>
                                <option value="64">Jill S. Tokuda</option></optgroup><optgroup label="Honolulu/Oahu County"><option value="89">Todd K. Apo</option>
                                <option value="90">Duke Bainum</option>
                                <option value="91">Romy M. Cachola</option>
                                <option value="92">Donavan M. Dela Cruz</option>
                                <option value="93">Charles K. Djou</option>
                                <option value="94">Nestor R. Garcia</option>
                                <option value="95">Barbara Marshall</option>
                                <option value="96">Gary H. Okino</option>
                                <option value="97">Rod Tam</option></optgroup><optgroup label="Maui County"><option value="81">Gladys Coelho Baisa</option>
                                <option value="82">Jo Anne Johnson</option>
                                <option value="83">Sol Kahoohalahala</option>
                                <option value="84">Danny A. Mateo</option>
                                <option value="85">Bill Kauakea Medeiros</option>
                                <option value="86">Michael J. Molina</option>
                                <option value="87">Joseph.Pontanilla</option>
                                <option value="88">Michael P. Victorino</option></optgroup><optgroup label="Hawaii County"><option value="65">Guy Enriques</option>
                                <option value="66">Brenda Ford</option>
                                <option value="67">Kelly Greenwell</option>
                                <option value="68">Donald Ikeda</option>
                                <option value="69">Pete Hoffmann</option>
                                <option value="70">Dennis Onishi</option>
                                <option value="71">Emily I. Naeole</option>
                                <option value="72">Dominic Yagong</option>
                                <option value="73">J Yoshimoto</option></optgroup><optgroup label="Kauai County"><option value="74">William Kaipo Asing</option>
                                <option value="75">Tim Bynum</option>
                                <option value="76">Vickie Chang</option>
                                <option value="77">Jay Furfaro</option>
                                <option value="78">Daryl W. Kaneshiro</option>
                                <option value="79">Lani Kawahara</option>
                                <option value="80">Derek Kawakami</option></optgroup>
                          </select>
                        </li>                                                  
                        <li>
                          <label class="labelLeft">Category</label>
                         	<select>
                            <option value="Agriculture and Food">Agriculture and Food</option>
                            <option value="Budget and Spending">Budget and Spending</option>
                            <option value="Business, Industry, and Consumers">Business, Industry, and Consumers</option>
                            <option value="Civil Rights">Civil Rights</option>
                            <option value="Economic Development">Economic Development</option>
                            <option value="Education">Education</option>
                            <option value="Employment">Employment</option>
                            <option value="Energy">Energy</option>
                            <option value="Environmental Protection">Environmental Protection</option>
                            <option value="Financial Institutions">Financial Institutions</option>
                            <option value="Financial Management">Financial Management</option>
                            <option value="Government Operations">Government Operations</option>
                            <option value="Hawaiian Affairs">Hawaiian Affairs</option>
                            <option value="Health">Health</option>
                            <option value="Homeland Security">Homeland Security</option>
                            <option value="Housing">Housing</option>
                            <option value="Income Security">Income Security</option>
                            <option value="Information Management">Information Management</option>
                            <option value="International Affairs">International Affairs</option>
                            <option value="Justice and Law Enforcement">Justice and Law Enforcement</option>
                            <option value="Natural Resources">Natural Resources</option>
                            <option value="Science, Space, and Technology">Science, Space, and Technology</option>
                            <option value="Social Services">Social Services</option>
                            <option value="Special Publications">Special Publications</option>
                            <option value="Tax Policy and Administration">Tax Policy and Administration</option>
                            <option value="Transportation">Transportation</option>
                            <option value="Other">Other</option>                          
                          </select>
                        </li>    
                        <li><label class="labelLeft">Description of the Bill</label><textarea rows="5" cols="40" class="uniform"></textarea></li>
                        <li><label class="labelLeft">Sample Talking Points</label><textarea rows="5" cols="40" class="uniform"></textarea></li>
                        <li><label class="labelLeft">Sample Testimony</label><textarea rows="5" cols="40" class="uniform"></textarea></li>
                        <li><span class="labelLeft">Video Testimony</span>
                        <div class="video"><a class="youtube" href="http://www.youtube.com/watch?v=TILzJ-_4urk">My great YouTube video</a></div>
                        </li>
                      </ul>      
                      <input class="superboton" type="submit" />            
                      

                    <h1>Bill Progress</h1>    
                    <div class="billUpdates">
                    	<div class="billUpdateTitle">oppose HB1226 protect local democracy!<span>02/12/2009 03:02 PM</span></div>
                        <p>I am not "anti-science", but do believe we have much to learn about genetic engineering. I also believe because of diversity throughout our State, that Counties should maintain their regulatory authority in regards genetic engineering and the associated health, environmental, agricultural and economic issues. There is a widely recognized need and opportunity in improving our food security and we need legislation that encourages rather than discourages local food systems. </p>
                    </div>
                    
					<div id="testimonyTabs">
                    
                        <div class="tabHeader">Submitted Testimony</div>
                        <div class="tabContent">
                            <a href="#" class="firstRow">
                                <span class="rowDescription">
                                <span class="rowTitle">96 people have submitted testimony for this bill so far.</span>
                                </span>
                            </a>
                            <a href="<?php bloginfo('url');?>/?p=205" class="tabContentRow">
                            	<span class="billName">Seth Corpuz-Lahne</span>
                                <span class="billMail">sethlahne@gmail.com</span>
                                <span class="billTestimony">03/ 5/2009 07:31 AM</span>
                                <span class="billMore">Click to read more...</span>
                            </a>
                            <a href="<?php bloginfo('url');?>/?p=205" class="tabContentRow">
                            	<span class="billName">Seth Corpuz-Lahne</span>
                                <span class="billMail">sethlahne@gmail.com</span>
                                <span class="billTestimony">03/ 5/2009 07:31 AM</span>
                                <span class="billMore">Click to read more...</span>
                            </a>
                            <a href="<?php bloginfo('url');?>/?p=205" class="tabContentRow">
                            	<span class="billName">Seth Corpuz-Lahne</span>
                                <span class="billMail">sethlahne@gmail.com</span>
                                <span class="billTestimony">03/ 5/2009 07:31 AM</span>
                                <span class="billMore">Click to read more...</span>
                            </a>       
                            <a href="<?php bloginfo('url');?>/?p=205" class="tabContentRow">
                            	<span class="billName">Seth Corpuz-Lahne</span>
                                <span class="billMail">sethlahne@gmail.com</span>
                                <span class="billTestimony">03/ 5/2009 07:31 AM</span>
                                <span class="billMore">Click to read more...</span>
                            </a>
                            <a href="<?php bloginfo('url');?>/?p=205" class="tabContentRow">
                            	<span class="billName">Seth Corpuz-Lahne</span>
                                <span class="billMail">sethlahne@gmail.com</span>
                                <span class="billTestimony">03/ 5/2009 07:31 AM</span>
                                <span class="billMore">Click to read more...</span>
                            </a>
                            <a href="<?php bloginfo('url');?>/?p=205" class="tabContentRow">
                            	<span class="billName">Seth Corpuz-Lahne</span>
                                <span class="billMail">sethlahne@gmail.com</span>
                                <span class="billTestimony">03/ 5/2009 07:31 AM</span>
                                <span class="billMore">Click to read more...</span>
                            </a> 
                            <a href="<?php bloginfo('url');?>/?p=205" class="tabContentRow">
                            	<span class="billName">Seth Corpuz-Lahne</span>
                                <span class="billMail">sethlahne@gmail.com</span>
                                <span class="billTestimony">03/ 5/2009 07:31 AM</span>
                                <span class="billMore">Click to read more...</span>
                            </a>
                            <a href="<?php bloginfo('url');?>/?p=205" class="tabContentRow">
                            	<span class="billName">Seth Corpuz-Lahne</span>
                                <span class="billMail">sethlahne@gmail.com</span>
                                <span class="billTestimony">03/ 5/2009 07:31 AM</span>
                                <span class="billMore">Click to read more...</span>
                            </a>
                            <a href="<?php bloginfo('url');?>/?p=205" class="tabContentRow">
                            	<span class="billName">Seth Corpuz-Lahne</span>
                                <span class="billMail">sethlahne@gmail.com</span>
                                <span class="billTestimony">03/ 5/2009 07:31 AM</span>
                                <span class="billMore">Click to read more...</span>
                            </a>                                                                              
                        </div> 
                  
                    </div>                                 
                                        
        
                </div>
            
            </div>
                    
          	<div id="contentRightBottom"></div>
        </div>        
		
    </div>
    
</div>   
</div>	
     
      
      <?php } else { ?>

<div id="content-page">              

		<div id="contentLeft">
        	
            <span class="contentLeftTitle"><span>Strong opposition to Bill 25 CD1 Raising Waikiki Parking Meter Fees</span></span>
            <ul>
            	<li><a href="#">
                	<h6>Category:</h6>
                	<p>Budget and Spending</p>
                </a></li>
            	<li><a href="#">
                	<h6>Description of Bill</h6>
                	<p>Honolulu City Council (Oahu County Council) is considering raising parking meter fees in Waikiki 600% -- up to $1.50 / hour. </p>
                </a></li>
            	<li><a href="#">
                	<h6>Hearing</h6>
                	<p>Wednesday, June 10, 2009 09:00 AM</p>
                </a></li>                                                                                        
                <li><a href="#" class="linkless"><img src="<?php bloginfo('stylesheet_directory') ?>/images/bg-leftbottombig.png" /></a></li>
            </ul>
            
        </div>
        
        <div id="contentRight">
        
        	<div id="contentRightTop">
                
                <div id="main">
                
                	<h1>Sample Talking Points</h1>
                
                	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
              
              		<?php the_content(); ?>   
                    <h1 style="margin:0;"><?php the_title(); ?></h1>
                        
					<?php endwhile; else: ?>
                    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
                    <?php endif; ?>    
                    
                    <h1>Video Testimony</h1>
                    <div class="bigvideo"><a class="youtubebig" href="http://www.youtube.com/watch?v=TILzJ-_4urk">My great YouTube video</a></div>                                                                      
                    
                           
                    <form>
                      <ul id="newBill" style="background:none; margin-top:-28px 10px 0 0;">
                        <li><label class="labelLeft">First Name</label><input type="text" size="40"/></li>                      
                        <li><label class="labelLeft">Last Name</label><input type="text" size="40"/></li>
                        <li><label class="labelLeft">Email Address</label><input type="text" size="40"/></li>
                        <li><label class="labelLeft">Address</label><input type="text" size="40"/></li>
                        <li><label class="labelLeft">City</label><input type="text" size="40"/></li>
                        <li><label class="labelLeft">State</label><input type="text" size="40"/></li>
                        <li><label class="labelLeft">Postal Code</label><input type="text" size="40"/></li>
                        <li><label class="labelLeft">Phone</label><input type="text" size="40"/></li>
                        <li><label class="labelLeft">Testimony</label><textarea cols="40" rows="5"></textarea></li>
                        <li><span class="labelLeft">Video Testimony</span>
                        <div class="video"><a class="youtube" href="http://www.youtube.com/watch?v=TILzJ-_4urk">My great YouTube video</a></div>
                        </li>
                      </ul>
                      	<input class="superboton" type="submit" />
                    </form>    
                    
                    <h1>Bill Progress</h1>    
                    <div class="billUpdates">
                    	<div class="billUpdateTitle">oppose HB1226 protect local democracy!<span>02/12/2009 03:02 PM</span></div>
                        <p>I am not "anti-science", but do believe we have much to learn about genetic engineering. I also believe because of diversity throughout our State, that Counties should maintain their regulatory authority in regards genetic engineering and the associated health, environmental, agricultural and economic issues. There is a widely recognized need and opportunity in improving our food security and we need legislation that encourages rather than discourages local food systems. </p>
                    </div>
                    
                    <h1>User Testimony</h1>   
                    <p><span class="rowTitle">96 people have submitted testimony for this bill so far.</span></p>
                    

                                
        
                </div>
            
            </div>
                    
          	<div id="contentRightBottom"></div>
        </div>        
		
    </div>
    
</div>   
</div>        
        

<?php } ?>

<div id="footer">                               
	<div id="footer_central">
		<div id="footer_ninja"></div>
        <a href="http://www.policyninja.org"><div id="footer_left"></div></a>
		<div id="footer_right"><a href="http://www.policyninja.org">Home</a>|<a href="http://www.policyninja.org/about/">About</a>|<a href="http://www.policyninja.org/education_and_training">Education</a>|<a href="http://www.policyninja.org/transparency">Transparency</a>|<a href="http://www.policyninja.org/action_page">Action</a>
        </div>
	</div>
</div>


</body>
</html>