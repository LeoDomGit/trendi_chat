<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LandingPageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        \App\Models\LandingPage::create(
            [
                'html_template'      => '<header class="section-header">

                <div class="container">
                    <div class="row">
                       <div class="main-logo col-md-6">
                          <div class="site-logo">  
                           <a href="/">
                            <img class="img-fluid" src="https://quickl-landing.siswebapp.com/images/quickl_logo.png" alt="logo">
                           </a>
                        </div>
                       </div> 
               
                       <div class="header-right col-md-6 text-right">
                           
                       </div> 
                    </div>
                </div>
                 
               
               </header>
               
               <div class="osahan-home-page">
               
                 <div class="home-banner">
                   
                  <div class="banner-inner">
                     <div class="container">   
                       <div class="row align-items-center">
                        <div class="col-md-6">  
                          <div class="homebanner-content">
                           <h1>Modernize customer service with chatbot</h1>
                           <p>We provide 24×7 support and modified chatbot services to modernize lengthy times and annoying communications, so what are you waiting for??</p>
                           <div class="ban-btn">
                               <a href="https://play.google.com/store/apps/details?id=com.app.quicklai"><img src="https://quickl-landing.siswebapp.com/images/play_store_btn 1.png"></a>
                               <a href="#"><img src="https://quickl-landing.siswebapp.com/images/app_store_btn 1.png"></a>
                           </div>
                         </div>
                        </div>
                        <div class="col-md-6 quickl-banner-right">
                           <div class="banner-img text-left">
                           <img src="https://quickl-landing.siswebapp.com/images/hero_img.png">
                           </div>
                        </div> 
                     </div>
                   </div>  
                   </div> 
               </div> 
               
               <section class="ask-anything pt-5 pb-5 section" id="ask-anything">    
                 <div class="container">
                   <div class="row align-items-center">
                       <div class="col-md-6 delapp-left">
                           <img src="https://quickl-landing.siswebapp.com/images/ask_anything_image1.png" alt="Ask Anything to your AI Assistants">
                       </div>
                       <div class="col-md-6 delapp-right pl-5 mt-m-5">
                           <div class="delapp-right-cont">
                              <div class="section-title position-relative"> 
                               <h2>Ask anything to your Al assistants</h2>
                               <div class="round round-right position-absolute"><img src="https://quickl-landing.siswebapp.com/images/round_bg.png" alt="Ask Anything to your AI Assistants"></div>
                              </div>
                               <p>Our 24×7 service provider gives you instant conversations for any query or any help. Ask anything you want! Ask anytime you want!</p> 
                               
                           </div>
                       </div>
                   </div>   
                 </div> 
               </section>
               
               <section class="ask-anything pt-5 pb-5 section bg-dark-green" id="ask-anything">    
                 <div class="container">
                   <div class="row align-items-center">
                       <div class="col-md-6 delapp-right pl-5 mt-m-5">
                           <div class="delapp-right-cont">
                              <div class="section-title position-relative"> 
                               <h2 class="text-white">Chat with Chat GPT</h2>
                               <div class="round round-left position-absolute"><img src="https://quickl-landing.siswebapp.com/images/round_bg.png" alt="Ask Anything to your AI Assistants"></div>
                              </div>
                               <p class="text-white">Chatting is the best option for any requirement, so chat with our chat GPT for your problems, English translations, email writings and many more and you will receive beautiful quick answers.</p> 
                               
                           </div>
                       </div>
                       <div class="col-md-6 delapp-left">
                           <img src="https://quickl-landing.siswebapp.com/images/chat_with_image.png" alt="Ask Anything to your AI Assistants">
                       </div>
                   </div>   
                 </div> 
               </section>
               
               
               <section class="ask-anything pt-5 pb-5 section" id="ask-anything">    
                 <div class="container">
                   <div class="row align-items-center">
                       <div class="col-md-6 delapp-left">
                           <img src="https://quickl-landing.siswebapp.com/images/generate_any_image.png" alt="Ask Anything to your AI Assistants">
                       </div>
                       <div class="col-md-6 delapp-right pl-5 mt-m-5">
                           <div class="delapp-right-cont">
                              <div class="section-title position-relative"> 
                               <h2>Generate any kind of image for Al assistant</h2>
                               <div class="round round-right position-absolute"><img src="https://quickl-landing.siswebapp.com/images/round_bg.png" alt="Ask Anything to your AI Assistants"></div>
                              </div>
                               <p>Did you know Al assistant can explore any kind of images like travelling, foods, nature, celebrity images, any kind of images you can received. Isn’t it exciting!!</p> 
                           </div>
                       </div>
                   </div>   
                 </div> 
               </section>
               
               <section class="ask-anything pt-5 pb-5 section bg-dark-green" id="ask-anything">    
                 <div class="container-fluid">
                   
                   <div class="section-title position-relative mb-3"> 
                      <h2 class="text-center mb-5 text-white">On-boarding screens</h2>
                      <div class="round round-left position-absolute"><img src="https://quickl-landing.siswebapp.com/images/round_bg.png" alt="Ask Anything to your AI Assistants"></div>
                   </div>
               
                   <div class="row">
                       <div class="col-md-12">
                         <div class="owl-carousel owl-theme">
                           <div class="item">
                             <img src="https://quickl-landing.siswebapp.com/images/screen1.png" alt="Ask Anything to your AI Assistants">
                           </div>
                           <div class="item">
                             <img src="https://quickl-landing.siswebapp.com/images/screen2.png" alt="Ask Anything to your AI Assistants">
                           </div>
                           <div class="item">
                             <img src="https://quickl-landing.siswebapp.com/images/screen3.png" alt="Ask Anything to your AI Assistants">
                           </div>
                           <div class="item">
                             <img src="https://quickl-landing.siswebapp.com/images/screen4.png" alt="Ask Anything to your AI Assistants">
                           </div>
                           <div class="item">
                             <img src="https://quickl-landing.siswebapp.com/images/screen5.png" alt="Ask Anything to your AI Assistants">
                           </div>
                           <div class="item">
                             <img src="https://quickl-landing.siswebapp.com/images/screen6.png" alt="Ask Anything to your AI Assistants">
                           </div>
                           <div class="item">
                             <img src="https://quickl-landing.siswebapp.com/images/screen7.png" alt="Ask Anything to your AI Assistants">
                           </div>
                           <div class="item">
                             <img src="https://quickl-landing.siswebapp.com/images/screen8.png" alt="Ask Anything to your AI Assistants">
                           </div>
                           <div class="item">
                             <img src="https://quickl-landing.siswebapp.com/images/screen9.png" alt="Ask Anything to your AI Assistants">
                           </div>
                           <div class="item">
                             <img src="https://quickl-landing.siswebapp.com/images/screen10.png" alt="Ask Anything to your AI Assistants">
                           </div>
                           <div class="item">
                             <img src="https://quickl-landing.siswebapp.com/images/screen11.png" alt="Ask Anything to your AI Assistants">
                           </div>
                         </div>
               
                       </div>
                   </div></div>
                 </section>
               
               
                 <section class="subscription-sec pt-5 pb-5 section" id="ask-anything">    
                 <div class="container">
                   <div class="section-title position-relative mb-5"> 
                      <h2 class="text-center mb-5">Subscription</h2>
                      <div class="round round-left position-absolute"><img src="https://quickl-landing.siswebapp.com/images/round_bg.png" alt="Ask Anything to your AI Assistants"></div>
                   </div>
                   <div class="row">
                     <div class="col-md-6 col-lg-3 sub-block">
                       <div class="sub-block-inner">
                          <div class="sub-box">
                           <h4>Weekly</h4>
                           <h3>$4.99</h3>
                           <ul>
                           <li><strong>High Word Limit</strong> for Questions &amp; Answers</li>
                           <li><strong>Unlimited</strong> Questions &amp; Answers</li>
                           <li><strong>Ads Free</strong> experience</li>
                           </ul>
                           </div>
                       </div>
                     </div>
                     
                      <div class="col-md-6 col-lg-3 sub-block">
                       <div class="sub-block-inner">
                        <div class="off-img">
                         <h2>10% OFF</h2>
                         <img src="https://quickl-landing.siswebapp.com/images/offer_img1.png" class="vc_single_image-img attachment-full" alt="" decoding="async" loading="lazy" title="offer_img1">
                        </div> 
                          <div class="sub-box">
                           <h4>Monthly</h4>
                           <h3>$17.99</h3>
                           <ul>
                           <li><strong>High Word Limit</strong> for Questions &amp; Answers</li>
                           <li><strong>Unlimited</strong> Questions &amp; Answers</li>
                           <li><strong>Ads Free</strong> experience</li>
                           </ul>
                           </div>
                       </div>
                     </div>
               
                     <div class="col-md-6 col-lg-3 sub-block">
                       <div class="sub-block-inner">
                        <div class="off-img">
                         <h2>16% OFF</h2>
                         <img src="https://quickl-landing.siswebapp.com/images/offer_img1.png" class="vc_single_image-img attachment-full" alt="" decoding="async" loading="lazy" title="offer_img1">
                        </div> 
                          <div class="sub-box">
                           <h4>Quarterly</h4>
                           <h3>$49.99</h3>
                           <ul>
                           <li><strong>High Word Limit</strong> for Questions &amp; Answers</li>
                           <li><strong>Unlimited</strong> Questions &amp; Answers</li>
                           <li><strong>Ads Free</strong> experience</li>
                           </ul>
                           </div>
                       </div>
                     </div>
               
                     <div class="col-md-6 col-lg-3 sub-block">
                       <div class="sub-block-inner">
                        <div class="off-img">
                         <h2>58% OFF</h2>
                         <img src="https://quickl-landing.siswebapp.com/images/offer_img1.png" class="vc_single_image-img attachment-full" alt="" decoding="async" loading="lazy" title="offer_img1">
                        </div> 
                          <div class="sub-box">
                           <h4>Yearly</h4>
                           <h3>$99.99</h3>
                           <ul>
                           <li><strong>High Word Limit</strong> for Questions &amp; Answers</li>
                           <li><strong>Unlimited</strong> Questions &amp; Answers</li>
                           <li><strong>Ads Free</strong> experience</li>
                           </ul>
                           </div>
                       </div>
                     </div>
               
                   </div>   
                 </div> 
               </section>
               
               
               <section class="contact-sec pt-5 pb-5 section" id="contact">    
                 <div class="container">
                   <div class="row align-items-center">
                       <div class="col-md-6 contact-left">
                           
                       </div>
                       <div class="col-md-6 contact-right pl-5">
                           <div class="contact-right-cont position-relative">
                              <div class="section-title position-relative"> 
                               <h2 class="text-white mb-3">Contact us</h2>
                              </div>
                              <div class="round round-right position-absolute"><img src="https://quickl-landing.siswebapp.com/images/round_bg.png" alt="Ask Anything to your AI Assistants"></div>
                               <ul>
                                   <li><img src="https://quickl-landing.siswebapp.com/images/mail.png"><a href="mailto:info@siddhiinfosoft.com">info@siddhiinfosoft.com</a></li>
                                   <li><img src="https://quickl-landing.siswebapp.com/images/mail.png"><a href="mailto:info@quickl.ai">info@quickl.ai</a></li>
                                   <li><img src="https://quickl-landing.siswebapp.com/images/mail.png">50 California Street, Suite 1500, San Francisco, California, 94111, USA</li>
                                   <li><img src="https://quickl-landing.siswebapp.com/images/mail.png">C-407, Ganesh Meridian, Opp. Amiraj Farm, S.G. Highway,Ahmedabad-380060,  GUJARAT, INDIA.</li>
                               </ul>
                               <p>©2023 Quickl. All Rights Reserved. <a href="https://quickl.ai/privacy-policy.html">Privacy Policy</a></p>
                               <p>Powered by Siddhi Infosoft. <a href="https://quickl.ai/terms-and-conditions.html">Terms &amp; Conditions.</a> | <a href="https://quickl.ai/faq.html">FAQ</a></p>
                           </div>
                       </div>
                   </div>   
                 </div> 
               </section>
               
               </div>
               
               <footer class="section-footer">
                  <div class="container">
                    
                  </div>     
                  <a href="#" id="toTopBtn" class="cd-top text-replace js-cd-top cd-top--is-visible cd-top--fade-out" data-abc="true"></a>
               </footer>',
            ]
        );
    }
}
