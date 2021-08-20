<?php

use Illuminate\Database\Seeder;
use App\AutoResponder;

class TemplateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AutoResponder::updateOrCreate([
            'template_name' => 'FORGOT_PASSWORD',
            'template' => '<center style="width: 100%; background-color: #fff;">
            <div class="email-container" style="max-width: 600px; margin: 0 auto; background-color: #ffffff;">
            <table style="margin: auto;" role="presentation" border="0" width="100%" cellspacing="0" cellpadding="0" align="center">
            <tbody>
            <tr>
            <td class="bg_white" style="padding: 1.2em 2.5em 1em 2.5em; background-color: #244e45;" valign="top">
            <table role="presentation" border="0" width="100%" cellspacing="0" cellpadding="0">
            <tbody>
            <tr>
            <td class="logo" style="text-align: center; color: #fff;">&nbsp;Freight Management</td>
            </tr>
            </tbody>
            </table>
            </td>
            </tr>
            <!-- end tr -->
            <tr style="border-left: 1px solid #e2e2e2; border-right: 1px solid #e2e2e2;">
            <td class="intro bg_white" style="padding: 2em 0;" valign="middle">
            <table>
            <tbody>
            <tr>
            <td>
            <div class="text" style="padding: 0 2.5em;">
            <h2 style="text-align: left; color: #000000; font-size: 18px; margin-top: 0; line-height: 1.4; font-weight: bold;">Hello {{$name}},</h2>
            <p style="text-align: left; margin-top: 15px;">You have recently requested to reset your password for your account. Click on this link to reset your password.</p>
            <p style="margin-top: 15px;"><a class="btn btn-black" style="background-color: #244e45; padding: 5px 20px; color: #fff;" href="{{$token}}">Click here</a></p>
            <p style="text-align: left; margin: 0px;">Or Copy the below link on your browser tab :</p>
            <p style="text-align: left;">{{$token}}</p>
            <p style="text-align: left;">If you did not initiate this request, please ignore this mail and the link will soon expire automatically.</p>
            <p style="margin: 10px 0 0; text-align: left; color: #000000;">Thanks</p>
            <p style="margin: 0px; text-align: left; color: #000000; font-weight: bold;">Dev Team</p>
            </div>
            </td>
            </tr>
            </tbody>
            </table>
            </td>
            </tr>
            <!-- end tr --> <!-- 1 Column Text + Button : END --></tbody>
            </table>
            <table style="margin: auto; background: #fafafa;" role="presentation" border="0" width="100%" cellspacing="0" cellpadding="0" align="center">
            <tbody>
            <tr>
            <td style="padding: 2px 200px 10px;">
            <table>
            <tbody>
            <tr>
            <td style="text-align: center; margin: 0;">
            <p style="margin: 0; font-size: 12px;">&copy; 2021 <a style="color: #141637;">Dev</a>. All Rights Reserved</p>
            </td>
            </tr>
            </tbody>
            </table>
            </td>
            </tr>
            </tbody>
            </table>
            </div></center>',
            'subject' => 'Reset Password'
        ]);
        AutoResponder::updateOrCreate([
            'template_name' => 'VERIFY_EMAIL',
            'template' => '<center style="width: 100%; background-color: #fff;">
            <div class="email-container" style="max-width: 600px; margin: 0 auto; background-color: #ffffff;">
            <table style="margin: auto;" role="presentation" border="0" width="100%" cellspacing="0" cellpadding="0" align="center">
            <tbody>
            <tr>
            <td class="bg_white" style="padding: 1.2em 2.5em 1em 2.5em; background-color: #244e45;" valign="top">
            <table role="presentation" border="0" width="100%" cellspacing="0" cellpadding="0">
            <tbody>
            <tr>
            <td class="logo" style="text-align: center; color: #fff;">&nbsp;Dev</td>
            </tr>
            </tbody>
            </table>
            </td>
            </tr>
            <!-- end tr -->
            <tr style="border-left: 1px solid #e2e2e2; border-right: 1px solid #e2e2e2;">
            <td class="intro bg_white" style="padding: 2em 0;" valign="middle">
            <table>
            <tbody>
            <tr>
            <td>
            <div class="text" style="padding: 0 2.5em;">
            <h2 style="text-align: left; color: #000000; font-size: 18px; margin-top: 0; line-height: 1.4; font-weight: bold;">Hello {{$name}},</h2>
            <p style="text-align: left; margin-top: 15px; margin-bottom: 0;">Welcome to Dev</p>
            <p style="text-align: left; margin: 0;">Thank you for signing up, we are excited to have you on board. Please activate your account by clicking on the following link and get verified.</p>
            <p style="margin-top: 15px;"><a class="btn btn-black" style="background-color: #244e45; padding: 5px 20px; color: #fff;" href="{{$token}}">Click here</a></p>
            <p style="text-align: left; margin: 0px;">Or click the direct link :</p>
            <p style="text-align: left;">{{$token}}</p>
            <p style="text-align: left;">Once that is completed from your end, your account will be activated.</p>
            <p style="text-align: left;">We are here to provide you with tons of great resources to help you get set up for success. But if you have any queries regarding your account, please mail us right away. We will be pleased to assist you.</p>
            <p style="margin: 10px 0 0; text-align: left; color: #000000;">Thanks</p>
            <p style="margin: 0px; text-align: left; color: #000000; font-weight: bold;">Dev Team</p>
            </div>
            </td>
            </tr>
            </tbody>
            </table>
            </td>
            </tr>
            <!-- end tr --> <!-- 1 Column Text + Button : END --></tbody>
            </table>
            <table style="margin: auto; background: #fafafa;" role="presentation" border="0" width="100%" cellspacing="0" cellpadding="0" align="center">
            <tbody>
            <tr>
            <td style="padding: 2px 200px 10px;">
            <table>
            <tbody>
            <tr>
            <td style="text-align: center; margin: 0;">
            <p style="margin: 0; font-size: 12px;">&copy; 2021 <a style="color: #141637;">Dev</a>. All Rights Reserved</p>
            </td>
            </tr>
            </tbody>
            </table>
            </td>
            </tr>
            </tbody>
            </table>
            </div>
            </center>',
            'subject' => 'Welcome to Dev, Verify your email'
        ]);
        AutoResponder::updateOrCreate([
            'template_name' => 'USER_REVIEW_RATING',
            'template' => '<center style="width: 100%; background-color: #fff;">
            <div class="email-container" style="max-width: 600px; margin: 0 auto; background-color: #ffffff;">
            <table style="margin: auto;" role="presentation" border="0" width="100%" cellspacing="0" cellpadding="0" align="center">
            <tbody>
            <tr>
            <td class="bg_white" style="padding: 1.2em 2.5em 1em 2.5em; background-color: #244e45;" valign="top">
            <table role="presentation" border="0" width="100%" cellspacing="0" cellpadding="0">
            <tbody>
            <tr>
            <td class="logo" style="text-align: center; color: #fff;">&nbsp; Dev</td>
            </tr>
            </tbody>
            </table>
            </td>
            </tr>
            <!-- end tr -->
            <tr style="border-left: 1px solid #e2e2e2; border-right: 1px solid #e2e2e2;">
            <td class="intro bg_white" style="padding: 2em 0;" valign="middle">
            <table>
            <tbody>
            <tr>
            <td>
            <div class="text" style="padding: 0 2.5em;">
            <h2 style="text-align: left; color: #000000; font-size: 18px; margin-top: 0; line-height: 1.4; font-weight: bold;">Hello {{$name}},</h2>
            {{$data}}
            <p style="text-align: left;"> Dev</p>
            <p style="text-align: left;"></p>
            <p style="margin: 10px 0 0; text-align: left; color: #000000;">Thanks</p>
            <p style="margin: 0px; text-align: left; color: #000000; font-weight: bold;">Dev Team</p>
            </div>
            </td>
            </tr>
            </tbody>
            </table>
            </td>
            </tr>
            <!-- end tr --> <!-- 1 Column Text + Button : END --></tbody>
            </table>
            <table style="margin: auto; background: #fafafa;" role="presentation" border="0" width="100%" cellspacing="0" cellpadding="0" align="center">
            <tbody>
            <tr>
            <td style="padding: 2px 200px 10px;">
            <table>
            <tbody>
            <tr>
            <td style="text-align: center; margin: 0;">
            <p style="margin: 0; font-size: 12px;">&copy; 2021 <a style="color: #141637;" > Dev</a>. All Rights Reserved</p>
            </td>
            </tr>
            </tbody>
            </table>
            </td>
            </tr>
            </tbody>
            </table>
            </div>
            </center>',
            'subject' => 'Product review and rating'
        ]);
    }
}
