<?php
/**
 * Premium Tab
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Affiliates
 * @version 1.0.0
 */

/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( ! defined( 'YITH_WCCL' ) ) {
    exit;
} // Exit if accessed directly
?>

<style>
    .section{
        margin-left: -20px;
        margin-right: -20px;
        font-family: "Raleway",san-serif;
    }
    .section h1{
        text-align: center;
        text-transform: uppercase;
        color: #808a97;
        font-size: 35px;
        font-weight: 700;
        line-height: normal;
        display: inline-block;
        width: 100%;
        margin: 50px 0 0;
    }
    .section ul{
        list-style-type: disc;
        padding-left: 15px;
    }
    .section:nth-child(even){
        background-color: #fff;
    }
    .section:nth-child(odd){
        background-color: #f1f1f1;
    }
    .section .section-title img{
        display: table-cell;
        vertical-align: middle;
        width: auto;
        margin-right: 15px;
    }
    .section h2,
    .section h3 {
        display: inline-block;
        vertical-align: middle;
        padding: 0;
        font-size: 24px;
        font-weight: 700;
        color: #808a97;
        text-transform: uppercase;
    }

    .section .section-title h2{
        display: table-cell;
        vertical-align: middle;
        line-height: 25px;
    }

    .section-title{
        display: table;
    }

    .section h3 {
        font-size: 14px;
        line-height: 28px;
        margin-bottom: 0;
        display: block;
    }

    .section p{
        font-size: 13px;
        margin: 25px 0;
    }
    .section ul li{
        margin-bottom: 4px;
    }
    .landing-container{
        max-width: 750px;
        margin-left: auto;
        margin-right: auto;
        padding: 50px 0 30px;
    }
    .landing-container:after{
        display: block;
        clear: both;
        content: '';
    }
    .landing-container .col-1,
    .landing-container .col-2{
        float: left;
        box-sizing: border-box;
        padding: 0 15px;
    }
    .landing-container .col-1 img{
        width: 100%;
    }
    .landing-container .col-1{
        width: 55%;
    }
    .landing-container .col-2{
        width: 45%;
    }
    .premium-cta{
        background-color: #808a97;
        color: #fff;
        border-radius: 6px;
        padding: 20px 15px;
    }
    .premium-cta:after{
        content: '';
        display: block;
        clear: both;
    }
    .premium-cta p{
        margin: 7px 0;
        font-size: 14px;
        font-weight: 500;
        display: inline-block;
        width: 60%;
    }
    .premium-cta a.button{
        border-radius: 6px;
        height: 60px;
        float: right;
        background: url(<?php echo YITH_WCCL_URL?>assets/images/upgrade.png) #ff643f no-repeat 13px 13px;
        border-color: #ff643f;
        box-shadow: none;
        outline: none;
        color: #fff;
        position: relative;
        padding: 9px 50px 9px 70px;
    }
    .premium-cta a.button:hover,
    .premium-cta a.button:active,
    .premium-cta a.button:focus{
        color: #fff;
        background: url(<?php echo YITH_WCCL_URL?>assets/images/upgrade.png) #971d00 no-repeat 13px 13px;
        border-color: #971d00;
        box-shadow: none;
        outline: none;
    }
    .premium-cta a.button:focus{
        top: 1px;
    }
    .premium-cta a.button span{
        line-height: 13px;
    }
    .premium-cta a.button .highlight{
        display: block;
        font-size: 20px;
        font-weight: 700;
        line-height: 20px;
    }
    .premium-cta .highlight{
        text-transform: uppercase;
        background: none;
        font-weight: 800;
        color: #fff;
    }

    .section.one{
        background: url(<?php echo YITH_WCCL_URL?>assets/images/01-bg.png) no-repeat #fff; background-position: 85% 75%
    }
    .section.two{
        background: url(<?php echo YITH_WCCL_URL?>assets/images/02-bg.png) no-repeat ; background-position: 15% 75%
    }
    .section.three{
        background: url(<?php echo YITH_WCCL_URL?>assets/images/03-bg.png) no-repeat #fff; background-position: 85% 75%
    }
    .section.four{
        background: url(<?php echo YITH_WCCL_URL?>assets/images/04-bg.png) no-repeat ; background-position: 15% 75%
    }
    .section.five{
        background: url(<?php echo YITH_WCCL_URL?>assets/images/05-bg.png) no-repeat #fff; background-position: 85% 75%
    }
    .section.six{
        background: url(<?php echo YITH_WCCL_URL?>assets/images/06-bg.png) no-repeat ; background-position: 15% 75%
    }
    .section.seven{
        background: url(<?php echo YITH_WCCL_URL?>assets/images/07-bg.png) no-repeat #fff; background-position: 85% 75%
    }

    @media (max-width: 768px) {
        .section{margin: 0}
        .premium-cta p{
            width: 100%;
        }
        .premium-cta{
            text-align: center;
        }
        .premium-cta a.button{
            float: none;
        }
    }

    @media (max-width: 480px){
        .wrap{
            margin-right: 0;
        }
        .section{
            margin: 0;
        }
        .landing-container .col-1,
        .landing-container .col-2{
            width: 100%;
            padding: 0 15px;
        }
        .section-odd .col-1 {
            float: left;
            margin-right: -100%;
        }
        .section-odd .col-2 {
            float: right;
            margin-top: 65%;
        }
    }

    @media (max-width: 320px){
        .premium-cta a.button{
            padding: 9px 20px 9px 70px;
        }

        .section .section-title img{
            display: none;
        }
    }
</style>
<div class="landing">
    <div class="section section-cta section-odd">
        <div class="landing-container">
            <div class="premium-cta">
                <p>
                    <?php echo sprintf( __('Upgrade to %1$spremium version%2$s of %1$sYITH WooCommerce Color and Label Variations%2$s to benefit from all features!','yith-color-and-label-variations-for-woocommerce'),'<span class="highlight">','</span>' );?>
                </p>
                <a href="<?php echo $this->get_premium_landing_uri() ?>" target="_blank" class="premium-cta-button button btn">
                    <span class="highlight"><?php _e('UPGRADE','yith-color-and-label-variations-for-woocommerce');?></span>
                    <span><?php _e('to the premium version','yith-color-and-label-variations-for-woocommerce');?></span>
                </a>
            </div>
        </div>
    </div>
    <div class="one section section-even clear">
        <h1><?php _e('Premium Features','yith-color-and-label-variations-for-woocommerce');?></h1>
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WCCL_URL?>assets/images/01.png" alt="<?php _e( 'Dual color attribute','yith-color-and-label-variations-for-woocommerce') ?>" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCCL_URL?>assets/images/01-icon.png" alt="icon 01"/>
                    <h2><?php _e('Dual color attribute','yith-color-and-label-variations-for-woocommerce');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('How many times did you have to deal with the handling of a %1$stwo-colored%2$s t-shirt and the decision of how to set its color or with the use of a label because the color didn’t satisfy your needs? %3$s Now things have changed! You could select up to two colors for each attribute and create the right matches for the products of your shop.', 'yith-color-and-label-variations-for-woocommerce'), '<b>', '</b>','<br>');?>
                </p>
                <p>
                    <?php echo sprintf(__('You could select up to two colors for each attribute and %1$screate the right matches%2$s for the products of your shop.', 'yith-color-and-label-variations-for-woocommerce'), '<b>', '</b>','<br>');?>
                </p>
            </div>
        </div>
    </div>
    <div class="two section section-odd clear">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCCL_URL?>assets/images/02-icon.png" alt="icon 02" />
                    <h2><?php _e('Tooltip','yith-color-and-label-variations-for-woocommerce');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('Tooltips are often used on the web: they are an %1$selegant way to give a preview about the content%2$s and they offer a useful information to the users. Take advantage of the plugin power to add tooltips to your product attributes.', 'yith-color-and-label-variations-for-woocommerce'), '<b>', '</b>');?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WCCL_URL?>assets/images/02.png" alt="<?php _e( 'Tooltip','yith-color-and-label-variations-for-woocommerce') ?>" />
            </div>
        </div>
    </div>
    <div class="three section section-even clear">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WCCL_URL?>assets/images/03.png" alt="<?php _e( 'Attribute description','yith-color-and-label-variations-for-woocommerce') ?>" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCCL_URL?>assets/images/03-icon.png" alt="icon 03" />
                    <h2><?php _e( 'Attribute description','yith-color-and-label-variations-for-woocommerce');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('Show the attribute description in product page and %1$sgive users as many information as possible%2$s in order to clear their doubts.', 'yith-color-and-label-variations-for-woocommerce'), '<b>', '</b>');?>
                </p>
            </div>
        </div>
    </div>
    <div class="four section section-odd clear">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCCL_URL?>assets/images/04-icon.png" alt="icon 04" />
                    <h2><?php _e('A richer shop page…','yith-color-and-label-variations-for-woocommerce');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('All the %1$svariations%2$s configured on products will be shown in "Shop" page too: users will have a complete overview about your e-commerce. ', 'yith-color-and-label-variations-for-woocommerce'), '<b>', '</b>');?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WCCL_URL?>assets/images/04.png" alt="<?php _e( 'Shop page','yith-color-and-label-variations-for-woocommerce') ?>" />
            </div>
        </div>
    </div>
    <div class="five section section-even clear">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WCCL_URL?>assets/images/05.png" alt="<?php _e( 'Mouse-over','yith-color-and-label-variations-for-woocommerce') ?>" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCCL_URL?>assets/images/05-icon.png" alt="icon 03" />
                    <h2><?php _e( 'Mouse-over','yith-color-and-label-variations-for-woocommerce');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('Now your wishes come true: by %1$schoosing the variation and hovering your mouse over it%2$s, the product image will dynamically turn into the variation image. %3$sA dedicated option will allow enabling or disabling this feature.', 'yith-color-and-label-variations-for-woocommerce'), '<b>', '</b>', '<br>');?>
                </p>
            </div>
        </div>
    </div>
    <div class="four section section-odd clear">
        <div class="landing-container">
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCCL_URL?>assets/images/06-icon.png" alt="icon 06" />
                    <h2><?php _e('Additional Information','yith-color-and-label-variations-for-woocommerce');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('Enhance the WooCommerce "Additional Information" tab in product page by showing the complete %1$slist of the attributes%2$s associated with the product.', 'yith-color-and-label-variations-for-woocommerce'), '<b>', '</b>');?>
                </p>
            </div>
            <div class="col-1">
                <img src="<?php echo YITH_WCCL_URL?>assets/images/06.png" alt="<?php _e( 'Additional Information','yith-color-and-label-variations-for-woocommerce') ?>" />
            </div>
        </div>
    </div>
    <div class="seven section section-even clear">
        <div class="landing-container">
            <div class="col-1">
                <img src="<?php echo YITH_WCCL_URL?>assets/images/07.png" alt="<?php _e( 'Different image gallery per variation','yith-color-and-label-variations-for-woocommerce') ?>" />
            </div>
            <div class="col-2">
                <div class="section-title">
                    <img src="<?php echo YITH_WCCL_URL?>assets/images/07-icon.png" alt="icon 07" />
                    <h2><?php _e( 'Different image gallery per variation','yith-color-and-label-variations-for-woocommerce');?></h2>
                </div>
                <p>
                    <?php echo sprintf(__('The admin can add a unique image gallery for each product variation. Showing the customer all different looks of the product, in the color of their choice. 
', 'yith-color-and-label-variations-for-woocommerce'), '<b>', '</b>', '<br>');?>
                </p>
            </div>
        </div>
    </div>
    <div class="section section-cta section-odd">
        <div class="landing-container">
            <div class="premium-cta">
                <p>
                    <?php echo sprintf( __('Upgrade to %1$spremium version%2$s of %1$sYITH WooCommerce Color and Label Variations%2$s to benefit from all features!','yith-color-and-label-variations-for-woocommerce'),'<span class="highlight">','</span>' );?>
                </p>
                <a href="<?php echo $this->get_premium_landing_uri() ?>" target="_blank" class="premium-cta-button button btn">
                    <span class="highlight"><?php _e('UPGRADE','yith-color-and-label-variations-for-woocommerce');?></span>
                    <span><?php _e('to the premium version','yith-color-and-label-variations-for-woocommerce');?></span>
                </a>
            </div>
        </div>
    </div>
</div>
