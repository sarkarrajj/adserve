<?php
		require ("path.php");
		require (PATH."include/include.php");

//*************************************************************************************************

		include ("public_session.php"); 

//*************************************************************************************************

		$wuserId = $_GET['wuserId'];
		$pageId = $_GET['pageId'];

		if ( $pageId == '' )
		{
			$pageId = getColumn("USER_WEBSITE", $wuserId, "ID", "USERID");
		}

		if ( $pageId == '' )
		{
			header("Location:index.php?info=".urlencode('Please select a website to see ads.'));
			die;
		}

//*************************************************************************************************

		if ( !($recWebsite = getRecord("USER_WEBSITE", $pageId)) )
		{
			header("Location:index.php?info=".urlencode('Website not found. Error Code - 02 -'));
			die;
		}

		$wuserId = $recWebsite['USERID'];

//*************************************************************************************************

		if ( !($recUser = getRecord("USER", $wuserId, "USERID")) )
		{
			header("Location:index.php?info=".urlencode('Website not found. Error Code - 01 -'));
			die;
		}

//*************************************************************************************************

		include ("header.php"); 

//*************************************************************************************************
?>
	<p align="left"><span class="style11 style7"><strong>Advertise on <?=$recWebsite['WEBSITE_NAME']?></strong></span></p>
	<p align="right"><strong><span class="style6 style22"><?=$recWebsite['WEBSITE_NAME']?></span></strong></p>
	<table width="100%" border="0">
		<tr>
			<td width="38%"><img src="thumbnail.php?url=<?=urlencode($recWebsite['WEBSITE_URL'])?>" alt="" width="160" height="120"></td>
			<td colspan="2">
				<div class="buy-area-call-to-action">
					<table width="240" border="0" align="center" cellpadding="0" cellspacing="0" class="buy-area-call-to-action-main-table" id="producttable">
						<tr>
							<td valign="top">
								<table width="100%" border="0" cellpadding="0" cellspacing="0">
								<form name="F" method=get action="<?=$ROOT?>buy_ad.php">
								<!-- <input type="hidden" name="return" value="<?=$ROOT?>website_page.php?pageId=<?=$pageId?>&"> -->
								<script language="JavaScript">var detailsforproductcpc = '<br/><br/><p></p>';var detailsforproductppi = '                 ';</script>
<?
	$defAd = array();
	$result = executeQuery("SELECT * FROM ".PREFIX."USER_AD_PRODUCT WHERE WEBSITE_ID='".$pageId."' AND ISVALID='Y'");
	$count = 0;
	while ( $row = getRow($result) )
	{
		$count++;
		$defAd = empty($defAd) ? $row : $defAd;
?>
									<script type="text/javascript">var detailsforproduct<?=$count?> = '         <p><strong>Next Ad Available:</strong>         <?=formatDate(getSellerNextAdAvailableOn($pageId))?> </p>         <p>Get your ad on <strong><?=str_replace("'", "\'", $recWebsite['WEBSITE_NAME'])?></strong> for <?=$row['DURATION']==0?$DOLLAR.$row['COST'].' per click':$row['DURATION'].' full day(s)'?>. </p>         <p><strong>Days: </strong><?=$row['DURATION']==0?'Variable':$row['DURATION']?><strong><br>      <?=$row['DURATION']==0?'Set Amount of Clicks: </strong>Your Choice':('Average '.($row['DURATION']==30?"Monthly":($row['DURATION']==7?"Weekly":($row['DURATION']==1?"Daily":$row['DURATION']." Day"))).' Clicks: </strong> '.(round(getAvgCPD($pageId, $row['ID'])*$row['DURATION'], 2)))?><br>            <strong><?=$row['DURATION']==0?'Set Cost Per Click: </strong>'.$currencySymbol.number_format($currencyRate*$row['COST'], 2):'Average Cost Per Click: </strong>'.$currencySymbol.number_format($currencyRate*getAvgCPC($pageId), 2)?><br>            </p>         ';</script>
<?
		if ( $defAd['ID'] == $row['ID'] )
		{
?>
		<script type="text/javascript">var activetr = 'product<?=$count?>'; var defaultdetails = detailsforproduct<?=$count?>;</script>
<?
		}
?>
									<tr class="" id="product<?=$count?>" onmouseover="document.getElementById(activetr).className = ''; document.getElementById('product<?=$count?>').className='buy-area-call-to-action-on'; document.getElementById('productdetails').innerHTML = detailsforproduct<?=$count?>;" onmouseout="document.getElementById(activetr).className = 'buy-area-call-to-action-on';if(activetr != 'product<?=$count?>') {document.getElementById('product<?=$count?>').className=''}; document.getElementById('productdetails').innerHTML = defaultdetails;">
										<td width="14%" class="buy-area-call-to-action-choose"><input name="productId" type="radio" value="<?=$row['ID']?>" <?=$defAd['ID'] == $row['ID'] ? "checked" : ""?> onclick="document.getElementById(activetr).className=''; activetr='product<?=$count?>'; defaultdetails = detailsforproduct<?=$count?>;" id="product1radio"></td>
										<td width="50%" class="buy-area-call-to-action-description"><?=$row['TITLE']?></td>
										<td width="36%" class="buy-area-call-to-action-price"><?=$currencySymbol.number_format($currencyRate*$row['COST'], 2)?></td>
									</tr>
<?
	}
?>
									<tr>
										<td colspan="3">&nbsp;</td>
									</tr>
									<tr>
										<td colspan="2"><!-- <span class="buy-area-call-to-action-description"><strong>Change Currency: </strong><br>
										<? if ( $currencySymbol == $DOLLAR ) {?>
												<a href="<?=$ROOT."currency.php?c=USD&r=website_page.php?pageId=".$pageId?>">Show Prices as $</a>
										<? } else { ?>
												<a href="<?=$ROOT."currency.php?c=GBP&r=website_page.php?pageId=".$pageId?>">Show Prices as &#163;</a>
										<? } ?>
												</span> --></td>
										<td align="left">
											<input type="image" src="<?=$ROOT?>images/buy.gif" name="buy" alt="" width="76" height="32">										</td>
									</tr>
								</form>
								</table>							</td>
						</tr>
						<tr>
							<td> </td>
						</tr>
					</table>
				</div>			</td>
		</tr>
		<tr>
			<td colspan="2"> </td>
			<td width="48%" rowspan="7" class="buy-area-call-to-action-details">
				<div id="productdetails">
					<p align="left"><strong>Next Ad Available:</strong> <?=formatDate(getSellerNextAdAvailableOn($pageId))?></p>
					<p align="left">Get your ad on <strong><?=$recWebsite['WEBSITE_NAME']?></strong> for <?=$defAd['DURATION']?> full day(s).</p>
					<p align="left"><strong>Days: </strong><?=$defAd['DURATION']==0?'Variable':$defAd['DURATION']?><strong><br>
					<? if ( $defAd['DURATION'] == 0 ) { ?>
							 Set Amount of Clicks: </strong> Your Choice<br>
						 <strong>Set Cost Per Click: </strong><?=$currencySymbol.number_format($currencyRate*$defAd['COST'], 2)?><br>
					<? } else { ?>
							 Average <?=($defAd['DURATION']==30?"Monthly":($defAd['DURATION']==7?"Weekly":($defAd['DURATION']==1?"Daily":$defAd['DURATION']." Day")))?> Clicks: </strong> <?=round(getAvgCPD($pageId, $defAd['ID'])*$defAd['DURATION'], 2)?><br>
						 <strong>Average Cost Per Click: </strong><?=$currencySymbol.number_format($currencyRate*getAvgCPC($pageId), 2)?><br>
					<? } ?>
					</p>
				</div>			</td>
		</tr>
		<tr>
			<td colspan="2">
				<div align="left">
					<span class="style22 style6"><strong><?=$recWebsite['WEBSITE_NAME']?> Website Stats </strong></span></div>			</td>
		</tr>
		<tr>
			<td> </td>
			<td width="14%"> </td>
		</tr>
		<tr>
			<td colspan="2">
				<div align="left">
					<strong>Alexa Ranking: </strong> <?=$recWebsite['ALEXA_RANKING']==0?'n/a':$recWebsite['ALEXA_RANKING']?></div>			</td>
		</tr>
		<tr>
			<td colspan="2">
				<div align="left">
					<strong>Google Page Rank: </strong> <?=getGooglePageRank($recWebsite['WEBSITE_URL'])?></div>			</td>
		</tr>
		<tr>
			<td colspan="2">
				<div align="left">
					<strong>Pageviews Per Day: </strong> <?=getAvgImpressionsForSeller($pageId)?></div>			</td>
		</tr>
		<tr>
			<td colspan="2">
				<div align="left">
					<strong>Daily Unique Users:</strong> <?=getAvgUniqueUsersForSeller($pageId)?></div>			</td>
		</tr>
		<tr>
			<td colspan="2">
				<div align="left">
					<strong>Average CPC: </strong> <?=$currencySymbol.number_format($currencyRate*getAvgCPC($pageId), 2)?></div>			</td>
			<td> </td>
		</tr>
		<tr>
			<td colspan="2">
				<div align="left">
					<strong>Member Since:</strong> <?=formatDateTime($recUser['REGISTERATION_DATE'], 'dS F Y')?></div>			</td>
			<td>
				<div align="left">
					<strong>Click Through Stat: </strong></div>			</td>
		</tr>
		<tr>
			<td>
				<div align="left">
					<a href="<?=$recWebsite['WEBSITE_URL']?>"><?=$recWebsite['WEBSITE_URL']?></a></div>			</td>
			<td></td>
			<td>
			<? if ( $rowHCIAD = getHighestClickthroughsSentInADayForSeller($pageId) ) { ?>
				<div align="left">
					On the <?=formatDateTime($rowHCIAD['CLICK_DATE'], 'dS F Y')?>, <strong><?=$recWebsite['WEBSITE_NAME']?></strong> sent <strong><?=$rowHCIAD['C']?></strong> users to one advertiser.</div>
			<? } ?>			</td>
		</tr>
		<tr>
		  <td>&nbsp;</td>
		  <td colspan="2">&nbsp;</td>
	  </tr>
		<tr>
			<td>
				<div align="left">
					<strong>Website Owners Description: </strong></div>			</td>
			<td colspan="2"> </td>
		</tr>
		<tr>
			<td colspan="3">
				<?=nl2br($recWebsite['DESCRIPTION'])?>			</td>
		</tr>
		<? if ( $recWebsite['WEBSITE_TAGS'] != '' ) { ?>
		<tr>
			<td colspan="3" align="right">
				<span style="color: #b5b2b2">
				<b>Website Tags:</b><br><br>
				<?
				$tagcount = 0;
				$arrTags = split(',', $recWebsite['WEBSITE_TAGS']);
				foreach ( $arrTags as $tag )
				{
					if ( $tagcount++ >= 10 )	break;
					echo $tag.' ';
				}
				?>
				</span>			</td>
		</tr>
		<? } ?>
	</table>
<?
//*************************************************************************************************

		include ("footer.php"); 
		
//*************************************************************************************************
?>
