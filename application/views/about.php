<?php include 'header.php'; ?>
<section id="main_content">
<span id="c2p-about-anchor">&nbsp;</span>
<article class="c2p-wrap">
    <section id="c2p-about">
        <section class="c2p-left">
            <h1>About Click2Promote</h1>
            <p>Click2Promote provides you a service to promote your website, domain, blog and to allow you to follow the web rank of your site. It's easy, Signup, fill out the form, URL address, name of your site, short description, and wait for approval (2 hours to 2 working days). 
            </p>
            <p>When your site is approved, you have the following:</p>
            <ul>
                <li><p>A location in our database and a tweet from out Twitter account, share on our Facebook wall, a Digg from our digg account, a "Stumble" on StumbleUpon.</p></li>
                <li><p>An account to login, which takes you to your personal dashboard. From the dashboard, you can see how popular your website is on the web (Google, Bing, Mamma, Youtube, Facebook, Twitter, Myspace appearances in public searches) and you'll have your Alexa traffic rank, for the past week.</p></li>
                <li><p>There is a history for every rank number, so you will have a clear view of what's happening.</p></li>
            </ul>
            <br /><br />

            <img src="<?= base_url(); ?>assets/images/c2p-dashboard-1.png" alt="Click2Promote Dashboard" />               
        </section>
       	<section class="c2p-right">
            <div class="mt20"></div>
            <img src="<?= base_url(); ?>assets/images/c2p-dashboard-1.png" alt="Click2Promote Dashboard" />            
            <div class="mt120"></div>
            <h1>What do you get?</h1>
            <ul>
                <li><p>History of the popularity of your web site;</p></li>
                <li><p>Clear view of what's happening with your domain;</p></li>
                <li><p>Results from the Top 7(Seven) search engines/social networks in one place.</p></li>
            </ul>
            <p>This will increase the chances of you being found, visited and promoted, and your project will be presented to more than 1(one) BILLION people and companies.</p>
            <section class="mb20"></section>
        </section>
    </section>
</article>
<span id="c2p-about-anchor">&nbsp;</span>
<article class="c2p-wrap">
    <section id="c2p-about">
        <section class="c2p-left">
            <h1>Sign Up!</h1>
            <form id="mijnformuliertje" action="#" method="post">
                <section class="rounded-bg">
                    <h2>Your information</h2>  
                    <input type="text" name="yourname" id="yourname"  maxlength="100" value="Your Name">
                    <input type="text" name="youremail" id="youremail"  maxlength="100" value="Your E-mail">
                </section>
                <section class="rounded-bg">
                    <h2>Choose a Password</h2>
                    <input type="password" name="password" id="password"  maxlength="100" >
                    <input type="password" name="password-again" id="password-again"  maxlength="100" >
                </section>
                <section class="rounded-bg">
                    <h2>Your Website Info</h2>
                    <input type="text" name="sitename" id="sitename"  maxlength="100" value="Your Site Name">
                    <input type="text" name="siteurl" id="siteurl"  maxlength="100" value="Your Site URL">
                    <input type="text" name="desc" id="desc"  maxlength="100" value="Short description of your site">
                </section>
                <input class="c2p-send" type="submit" name="c2p-send" value="Complete Registration">

            </form>
        </section>
    </section>
</article>

</section>

<?php include 'footer.php'; ?>