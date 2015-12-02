<?php
		require ("path.php");
		require (PATH."include/include.php");

//*************************************************************************************************

		include ("session.php");

//*************************************************************************************************

		$userEmail		= getColumn("USERINFO", $userId, "EMAIL", "USERID");
		$isSubscribed	= getColumn("MAILINGLIST_MEMBER", $userEmail, "ISSUBSCRIBED", "EMAIL");

//*************************************************************************************************

		$pageHeading = "My Account";
		include ("header.php"); 

//*************************************************************************************************
?>
							<table width="100%" border="0">
								<tr>
									<td width="1186">
										<div align="left">
											<span class="style22 style6"><strong>Website Owners </strong></span></div>
									</td>
									<td width="1" class="buy-area-call-to-action-details"> </td>
									<td width="1189">
										<div align="left">
											<span class="style22 style6"><strong>Buying Ads </strong></span></div>
									</td>
								</tr>
								<tr>
									<td>
										<div class="splitleft">
											<div class="bluebox">
												<div align="left">
													<strong><a href="<?=$ROOT?>seller_earnings.php" class="style32">Earnings</a> <br>
														<a href="<?=$ROOT?>seller_setrates.php" class="style32">Set Ad Rates and Settings</a> <br>
														<a href="<?=$ROOT?>seller_adsapproval.php" class="style32">Approve / Reject New Advertisers</a> <br>
														<a href="<?=$ROOT?>seller_liveadstats.php" class="style32">View Live Ad Stats</a> <br>
														<a href="<?=$ROOT?>seller_paymenthistory.php" class="style32">Payment History</a> <br>
														<a href="<?=$ROOT?>seller_websitedetails.php?websiteId=<?=getColumn("USER_WEBSITE", $userId, "ID", "USERID")?>" class="style32">Update Website Details</a> <br>
														<a href="<?=$ROOT?>seller_accountdetails.php" class="style32">Update Account Details</a> <br>
														<a href="<?=$ROOT?>seller_htmlcode.php" class="style32">Get Ad HTML Code For Your Website</a><br>
														 <a href="<?=$ROOT?>seller_featured.php" class="style32">Further Promotion</a> <br>
														 <a href="<?=$ROOT?>seller_network_ads.php" class="style32">Network Ads</a> <br>
													</strong></div>
											</div>
										</div>
									</td>
									<td> </td>
									<td>
										<div class="splitleft">
											<div class="bluebox">
												<div align="left">
													<strong><span class="style32"><a href="<?=$ROOT?>buyer_adsrunning.php" class="style31">Current Ads Running</a> <br>
															<a href="<?=$ROOT?>browse.php" class="style33">Buy Ads</a> <br>
															<a href="<?=$ROOT?>buyer_liveadstats.php" class="style31">View Live Ad Stats</a></span><br>
														 <a href="<?=$ROOT?>buyer_detailedstats.php" class="style32">Detailed Ad Stats - Past &amp; Present</a> <br>
														<a href="<?=$ROOT?>buyer_purchasehistory.php" class="style32">Purchase History Statement</a> <br>
														<a href="<?=$ROOT?>buyer_conversioncode.php" class="style32">Conversion Tracking Code</a> <br>
														<a href="<?=$ROOT?>buyer_accountdetails.php" class="style32">Update Account Details</a><br>
														 <a href="<?=$ROOT?>buyer_purchasehistory.php" class="style32">Account Balance </a><span class="style30"><br>
															<br>
														</span></strong></div>
											</div>
										</div>
									</td>
								</tr>
								<tr>
									<td colspan="3"> </td>
								</tr>
								<tr>
									<td colspan="3">
										<div align="left">
											<span class="style22 style6"><strong>Newsletter</strong></span></div>
									</td>
								</tr>
								<tr>
									<td colspan="3">
										<div class="splitleft">
											<div class="bluebox">
												<div align="left">
													<table width="100%" border="0">
													<form name="F" action="mailinglist-subscribe.php?" method="POST" onSubmit="return validateForm(this);">
														<input type="hidden" name="return"		 value="welcome.php?">
														<input type="hidden" name="categories[]" value="1000">
														<input type="hidden" name="name" value="<?=$userId?>">
														<input type="hidden" name="email" value="<?=$userEmail?>">
														<tr>
															<td colspan="4" class="style38"><strong><a href="seller_paymenthistory.html" class="style32">Would you like to receive the Adserve Newsletter? </a></strong><br>
														  <?=$isSubscribed=="Y"?"You are currently subscribed":"You are currently not subscribed"?> </td>
														</tr>
														<tr>
															<td width="25%" class="style38"> </td>
															<td width="25%" class="style38"><input name="isSubscribed" type="radio" <?=$isSubscribed=="Y"?"checked":""?> value="Y"><strong>Yes</strong></td>
															<td width="25%" class="style38"><input name="isSubscribed" type="radio" <?=$isSubscribed=="N"?"checked":""?> value="N"><strong>No</strong></td>
															<td width="25%" class="style38"><input type="submit" name="Submit2" value="Update"></td>
														</tr>
													</form>
													</table>
													<strong><br>
													</strong></div>
											</div>
										</div>
									</td>
								</tr>
							</table>
<?
//*************************************************************************************************

		include ("footer.php"); 
		
//*************************************************************************************************
?>
