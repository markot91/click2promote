               <section id="c2p-contact" class="gray">
                   <article class="c2p-wrap gray">

                <section class="c2p-left">
                            <h1>Contact Click2Promote</h1>
                            <form id="mijnformuliertje" class="send-message" action="<?=site_url("home/contact");?>" method="post">
                                <input type="text" name="c2p-myemail" id="c2p-myemail" maxlength="100" value="Your E-mail">
                                <textarea class="c2p-mymessage" id="c2p-mymessage" rows="10" cols="20" name="poraka"></textarea>
                                <input id="c2p-send" class="c2p-send submit-button" type="submit" name="c2p-send" value="Send message">
                            </form>
                            <div class="mb20"></div>
                </section>

                       <section class="c2p-right">
                           <h1>Get Social with us!</h1>
                           <section id="social">
                               <ul>
                    <li><a href="https://www.facebook.com/Click2Promote.me" target="_blank"><img src="<?= base_url(); ?>assets/images/c2p-icon-facebook.png" alt="Facebook" /></a></li>
                    <li><a href="https://twitter.com/click2promote" target="_blank"><img src="<?= base_url(); ?>assets/images/c2p-icon-twitter.png" alt="Twitter" /></a></li>
                    <li><br/><h1>Share :</h1><br/><span class='st_sharethis_large' displayText='ShareThis'></span>
                        <span class='st_email_large' displayText='Email'></span></li>
                        <span class='st_facebook_large' displayText='Facebook'></span>
                        <span class='st_twitter_large' displayText='Tweet'></span>
                        <span class='st_linkedin_large' displayText='LinkedIn'></span>
                        <span class='st_stumbleupon_large' displayText='StumbleUpon'></span>
                        <span class='st_googleplus_large' displayText='Google +'></span>
                        <span class='st_digg_large' displayText='Digg'></span>
                        <span class='st_delicious_large' displayText='Delicious'></span>
                        <span class='st_myspace_large' displayText='MySpace'></span>
                        <span class='st_pinterest_large' displayText='Pinterest'></span>
                        <br/>
                        <br/>
                        <span class='st_plusone_large' displayText='Google +1'></span>
                        <span class='st_fblike_large' displayText='Facebook Like'></span>
                               </ul>
                           </section>
                       </section>
                       <div class="clear mb20"></div>
                   </article>  
               </section> 
       <footer>
            <article class="c2p-wrap">
                    <p>&copy;<?=date('Y');?> Click2Promote.me | Site by <a target="_blank" href="http://www.pixelicious.nl">Pixelicious</a>  | All rights reserved  | <a href="<?= site_url('home/terms'); ?>">Terms of use and disclaimer</a></p>
            </article>
       </footer>
</body>
</html>
