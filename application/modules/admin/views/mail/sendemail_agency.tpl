<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
   <title>Send Mail</title>

   <style type="text/css">
      {literal}
      #outlook a {padding:0;} /* Force Outlook to provide a "view in browser" menu link. */
      body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}
      /* Prevent Webkit and Windows Mobile platforms from changing default font sizes, while not breaking desktop design. */
      .ExternalClass {width:100%;} /* Force Hotmail to display emails at full width */
      .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;} /* Force Hotmail to display normal line spacing.*/
      #backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
      img {outline:none; text-decoration:none;border:none; -ms-interpolation-mode: bicubic;}
      a img {border:none;}
      .image_fix {display:block;}
      p {margin: 0px 0px !important;}
      table td {border-collapse: collapse;}
      table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }
      a {color: #0a8cce;text-decoration: none;text-decoration:none!important;}
      /*STYLES*/
      table[class=full] { width: 100%; clear: both; }

      /*IPAD STYLES*/
      @media only screen and (max-width: 640px) {
         a[href^="tel"], a[href^="sms"] {
            text-decoration: none;
            color: #0a8cce; /* or whatever your want */
            pointer-events: none;
            cursor: default;
         }
         .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
            text-decoration: default;
            color: #0a8cce !important;
            pointer-events: auto;
            cursor: default;
         }
         table[class=devicewidth] {width: 440px!important;text-align:center!important;}
         table[class=devicewidth2] {width: 350px!important;text-align:center!important;}
         table[class=devicewidthinner] {width: 420px!important;text-align:center!important;}
         table[class=devicewidlist]{width: 228px!important;}
         table[class=hide2]{width:25px!important;}
         table[class=hide2] img{width:25px!important;}
         img[class=banner] {width: 440px!important;height:220px!important;}
         img[class=colimg2] {width: 440px!important;height:220px!important;}
         
         img[class~=logo-img] { width:140px !important; height:auto !important; max-width: 140px !important;}
         table[class~=fn] { float:none !important;}
      }
      /*IPHONE STYLES*/
      @media only screen and (max-width: 480px) {
         a[href^="tel"], a[href^="sms"] {
            text-decoration: none;
            color: #0a8cce; /* or whatever your want */
            pointer-events: none;
            cursor: default;
         }
         .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {
            text-decoration: default;
            color: #0a8cce !important; 
            pointer-events: auto;
            cursor: default;
         }
         table[class=devicewidth] {width: 280px!important;text-align:center!important;}
         table[class=devicewidth2] {width: 260px!important;text-align:center!important;}
         table[class=devicewidthinner] {width: 260px!important;text-align:center!important;}
         table[class=devicewidlist]{width: 100px!important;}
         table[class=hide2]{width:20px!important;}
         table[class=hide2] img{width:20px!important;}
         img[class=banner] {width: 280px!important;height:140px!important;}
         img[class=colimg2] {width: 280px!important;height:140px!important;}
         td[class=mobile-hide]{display:none!important;}
         td[class="padding-bottom25"]{padding-bottom:25px!important;}

         img[class~=logo-img] { max-width: 140px !important;}
         table[class~=fn] { float:none !important;}	
      }
      {/literal}
   </style>

</head>
<body>

   <!-- Start of preheader -->
   <table width="101%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="preheader" >
      <tbody>
         <tr>
            <td>
               <table width="600" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                  <tbody>
                     <tr>
                        <td width="100%" align="center">
                           <table width="650" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                              <tbody>
                                 <!-- Spacing -->
                                 <tr>
                                  <td width="5%">&nbsp;</td>								
                                  <td width="95%" height="50"></td>
                               </tr>
                               <!-- Spacing -->
                               <tr>
                                 <td>&nbsp;</td>
                                 <td align="center">
                                    <table align="left" class="fn">
                                       <tr>
                                        <td width="265" style="padding: 18px 0 24px;">
                                        <a href="http://www.airtrippy.vn/" style="outline: none;" title="Airtrippy"><img src="{$base_tlp_front}/images/logo.png" alt="Airtrippy" class="logo-img" style="border: 0;display: block;-ms-interpolation-mode: bicubic;"></a>								</td>
                                        </tr>
                                     </table>
                                  </td>
                               </tr>                  
                            </tbody>
                         </table>
                      </td>
                   </tr>
                </tbody>
             </table>
          </td>
       </tr>
    </tbody>
 </table>
 <!-- End of preheader -->

 <!-- Start of USD -->
 <table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="full-text">
   <tbody>
      <tr>
         <td>
            <table width="650" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
               <tbody>
                  <tr>
                     <td width="100%">

                      <table width="650" align="center" border="0" cellpadding="0" cellspacing="0" class="devicewidth" style="background-color:#f8b92c;">
                        <tr>
                           <td align="center" class="h6" height="35" style="font-family: Arial;color: #fff;font-size: 14pt;line-height: 18px;">
                              <span style="text-decoration: none; outline: none;color:#fff;">Thông tin liên hệ tại AirTrippy</span></td>
                           </tr>
                        </table>

                     </td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>
<!-- End of USD -->

<!-- Start Full Text -->
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="full-text">
   <tbody>
      <tr>
         <td>
            <table width="650" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
               <tbody>
                  <tr>
                     <td width="100%" style="background-color:#f5f7fa;">
                        <table width="650" cellpadding="0" cellspacing="0" border="0" align="center" class="devicewidth">
                           <tbody>
                              <!-- Spacing -->
                              <tr>
                                 <td colspan="3" height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                              </tr>
                              <!-- Spacing -->
                              <tr>
                                 <td width="25">
                                    <img  src="http://dev.panpic.vn/newsletter/html/mailchimp/images/spacer.gif" width="1" height="1" style="border: 0;display: block;-ms-interpolation-mode: bicubic;" />
                                 </td>
                                 <td>


                                    <table width="600" align="center" border="0" cellspacing="0" cellpadding="0" class="devicewidthinner" style="border-collapse: collapse;background-color:#FFFFFF;" background="#fff;">
                                      <!--start title-->
                                      <tr>
                                        <td width="10">
                                          <img  src="http://dev.panpic.vn/newsletter/html/mailchimp/images/spacer.gif" width="1" height="1" style="border: 0;display: block;-ms-interpolation-mode: bicubic;" />
                                       </td>
                                       <td class="h3 b title-td"  style="color:#000000;font-size:14px;font-family:Arial;">

                                          <table width="580">
                                             <tr>
                                               <td>
                                                  <br />
                                                  {$item.agency_name} thân mến<br />
                                                  <br />
                                               </td>
                                            </tr>
                                         </table>
                                         <br />
                                         <table width="580" style=" border-bottom:2px solid #0194E9">
                                            <tr>
                                              <td><strong>Thông tin tài khoản Agency trên AirTrippy.vn</strong>:</td>
                                           </tr>
                                        </table>
                                        <br />

                                        Thông tin: <br /> <br />

                                        Tên Agency: {$item.agency_name}<br />
                                        Email đăng nhập: {$item.email}<br />
                                        Password: {$item.password}<br />
                                        <br />
                                        <br />

                                        - Link xem thông tin Agency: Bạn có thể <a href="{$item.link_agency}">click vào đầy</a> để xem thông tin chi tiết Agency
                                        <br />
                                        <br />
                                        - Link xem thông tin tours & thống kê tours: Bạn có thể <a href="{$item.link_user_login}">click vào đầy</a> để xem thông tin tours & thống kê tours

                                        <br /> 
                                        Ban quản trị AirTrippy <br />

                                     </td>
                                     <td width="10">
                                       <img  src="http://dev.panpic.vn/newsletter/html/mailchimp/images/spacer.gif" width="1" height="1" style="border: 0;display: block;-ms-interpolation-mode: bicubic;" />
                                    </td>	
                                 </tr>
                              </table>

                           </td>
                           <td width="25">
                            <img  src="http://dev.panpic.vn/newsletter/html/mailchimp/images/spacer.gif" width="1" height="1" style="border: 0;display: block;-ms-interpolation-mode: bicubic;" />
                         </td>
                      </tr>
                      <!-- Spacing -->
                      <tr>
                        <td colspan="3" height="20" style="font-size:1px; line-height:1px; mso-line-height-rule: exactly;">&nbsp;</td>
                     </tr>
                     <!-- Spacing -->
                  </tbody>
               </table>
            </td>
         </tr>
      </tbody>
   </table>
</td>
</tr>
</tbody>
</table>
<!-- end of full text -->

<!-- Start of footer -->
<table width="100%" bgcolor="#ffffff" cellpadding="0" cellspacing="0" border="0" id="backgroundTable" st-sortable="seperator">
   <tbody>
      <tr>
         <td>
            <table width="600" align="center" cellspacing="0" cellpadding="0" border="0" class="devicewidth">
               <tbody>                 
                  <tr>
                     <td width="650" align="center" height="1" bgcolor="#c9e5fb">

                       <table width="650" align="center" border="0" cellspacing="0" cellpadding="0" class="devicewidth">
                          <tr>
                            <td colspan="3" height="30">&nbsp;</td>
                         </tr>
                         <tr>
                            <td width="25"><img  src="http://dev.panpic.vn/newsletter/html/mailchimp/images/spacer.gif" width="1" height="1" style="border: 0;display: block;-ms-interpolation-mode: bicubic;" /></td>
                            <td>
                               <table width="600" align="center" border="0" cellspacing="0" cellpadding="0" class="devicewidth">
                                 <!--start title-->
                                 <tr>
                                    <td class="h3 b title-td"  style="font-family: 'Arial'; color: #000; font-size:12px; line-height: 30px;">
                                       {$item.email_footer}
                                    </td>
                                 </tr>
                                 <tr>
                                    <td align="center" class="title-td">&nbsp;  </td>
                                 </tr>
                                 <!--end content-->
                              </table>
                           </td>
                           <td width="25"><img  src="http://dev.panpic.vn/newsletter/html/mailchimp/images/spacer.gif" width="1" height="1" style="border: 0;display: block;-ms-interpolation-mode: bicubic;" /></td>
                        </tr>
                     </table>							

                  </td>
               </tr>
            </tbody>
         </table>
      </td>
   </tr>
</tbody>
</table>
<!-- End of Footer -->
</body>
</html>
