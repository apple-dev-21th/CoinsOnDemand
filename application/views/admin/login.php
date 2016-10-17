<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>

        <title>PersonalizedCoins Admin - Login</title>

        <meta charset="utf-8" />
        <meta name="description" content="" />
        <meta name="author" content="" />		
        <meta name="viewport" content="width=device-width,initial-scale=1" />

        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/stylesheets/reset.css" type="text/css" media="screen" title="no title" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/stylesheets/text.css" type="text/css" media="screen" title="no title" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/stylesheets/buttons.css" type="text/css" media="screen" title="no title" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/stylesheets/theme-default.css" type="text/css" media="screen" title="no title" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/stylesheets/login.css" type="text/css" media="screen" title="no title" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/stylesheets/all.css" type="text/css" />
    </head>

    <body>


        <div id="login">
            
            <h1>Dashboard</h1>
            
            <div id="login_panel">
                
                <?php echo form_open('admin/login'); ?>
                <?php if (validation_errors()) { ?>
                <div class="notify notify-error">
                    <a href="javascript:;" class="close">×</a>
                    <h3>Error Notifty</h3>
                    <?php echo validation_errors(); ?>
                </div>
                <?php
            }
            $this->load->view('admin/include/flash');
            ?> 
                
                    <div class="login_fields">
                        <div class="field">
                            <label for="email">User Name</label>
                            <input type="text" name="username" value="<?php echo set_value('username')?>" id="username" tabindex="1" placeholder="User Name" />		
                        </div>

                        <div class="field">
<!--                            <label for="password">Password <small><a href="javascript:;">Forgot Password?</a></small></label>-->
                            <input type="password" name="password" value="<?php echo set_value('password')?>" id="password" tabindex="2" placeholder="password" />			
                        </div>
                    </div> <!-- .login_fields -->

                    <div class="login_actions">
                        <button type="submit" class="btn btn-primary" tabindex="3">Login</button>
                    </div>
                    <?php // echo form_close(); ?>
                </form>
            </div> <!-- #login_panel -->		
        </div> <!-- #login -->

        <script src="<?php echo base_url(); ?>assets/javascripts/all.js"></script>


    </body>
</html>
