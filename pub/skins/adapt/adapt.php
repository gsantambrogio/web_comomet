<?php if (!defined('PmWiki')) exit();
/**
* adapt.php - PHP script for PmWiki Adapt Skin 
*
* This file will be overwritten when the skin is upgraded.
* You can create a $SkinDir/adaptconfig.php to use for 
* skin configuration.
*/
SDV($GLOBALS['SkinVersion'],'2017-09-26');

global $FmtPV, $action, $WikiTitle, $SkinDirUrl, $ScriptUrl, $PageLogoUrl,
  $HTMLHeaderFmt, $HTMLStylesFmt, $AdaptMinCss, $AdaptHomeTitleEna,
  $AdaptWikiLogoEna, $AdaptWikiTagline, $AdaptTagHomeOnly, $AdaptLogoFmt,
  $AdaptEditTitleEna, $AdaptSearchTitleEna, $AdaptEditHeaderEna,
  $AdaptPoweredByEna;

## {$Skin} and {$SkinVersion} page variables
SDV($FmtPV['$Skin'],'$GLOBALS["Skin"]');
SDV($FmtPV['$SkinVersion'],'$GLOBALS["SkinVersion"]');

## $SkinDir/adaptconfig.php is an optional skin configuration file
if (file_exists($GLOBALS['SkinDir'].'/adaptconfig.php'))
  include_once($GLOBALS['SkinDir'].'/adaptconfig.php');

## $SkinDir/custom.css is an optional custom stylesheet.
SDV($GLOBALS['AdaptCustomStylesheet'],'custom.css');   // configurable filename
$CustomCssFile = $GLOBALS['AdaptCustomStylesheet'];
if (file_exists($GLOBALS['SkinDir'].'/'.$CustomCssFile)) {
  $CustomCssLink='
    <link rel="stylesheet" href="'.$SkinDirUrl.'/'.$CustomCssFile.'">'."\n";
  $HTMLHeaderFmt = array("customcsslink"=>"$CustomCssLink")+$HTMLHeaderFmt;
}

##  Optionally use minified version of the adapt.css stylesheet
SDV($AdaptMinCss, 0);
$GLOBALS['AdaptCss'] = ($AdaptMinCss) ? 'adapt-min.css' : 'adapt.css'; 

## Suppress page name on Home Page
SDV($AdaptHomeTitleEna,0);
if (! $AdaptHomeTitleEna && $GLOBALS['pagename'] == $GLOBALS['DefaultPage'])
  SetTmplDisplay('PageAdaptTitleFmt',0);
else 
  SetTmplDisplay('PageAdaptTitleHomeFmt',0);

## Text or graphic logo, with or without a tagline
## with $DefaultPage-only option
$Tagline = (isset($AdaptWikiTagline) &&
    $GLOBALS['pagename'] == $GLOBALS['DefaultPage'] ||
    ! $AdaptTagHomeOnly)  // $DefaultPage-only option
  ? "<div id='tagline'>$AdaptWikiTagline</div>"
  : '';
$AdaptLogoFmt = ($AdaptWikiLogoEna)
  ? "<div id='wikilogo'><a href='{$ScriptUrl}' title='$WikiTitle'><img
    src='$PageLogoUrl' alt='$WikiTitle' border='0' /></a>$Tagline</div>"
  : "<div id='wikilogotxt'><a
    href='$ScriptUrl' title='$WikiTitle'>$WikiTitle</a>$Tagline</div>";

## favicon string
SDV($GLOBALS['AdaptFaviconEna'],1); // enabled by default
// build the string and add it to the top of $HTMLHeaderFmt array
if ($GLOBALS['AdaptFaviconEna'] == 1) {
  SDV($GLOBALS['AdaptFaviconUrl'],"$SkinDirUrl/adapticon.ico"); // default icon
  SDV($GLOBALS['AdaptTouchiconUrl'],"$SkinDirUrl/apple-touch-icon.png"); // default icon
  $IconUrl = $GLOBALS['AdaptFaviconUrl'];
  $TouchiconUrl = $GLOBALS['AdaptTouchiconUrl'];
  $IconLinkStr = "
    <link rel='icon' href='$IconUrl' type='image/x-icon' />
    <link rel='apple-touch-icon' href='$TouchiconUrl' />\n";
  $HTMLHeaderFmt = array("favicon"=>"$IconLinkStr")+$HTMLHeaderFmt; 
}

## admin PageActions (TODO)
SetTmplDisplay('PageAdminFmt',0);

## Remove the page title from search results pages.
SDV($AdaptSearchTitleEna, 0);
if ($action == 'search' && ! $AdaptSearchTitleEna)
  SetTmplDisplay('PageTitleFmt',0);

## Raise the edit page textarea (configurable).
SDV($AdaptEditHeaderEna,1);   // show site header by default
if (preg_match('/^(addlink|edit|diff|upload)$/', $action)) {
 if (!$AdaptEditHeaderEna) SetTmplDisplay('PageHeaderFmt',0);
 if (!$AdaptEditTitleEna) SetTmplDisplay('PageTitleFmt',0);
}

## PagePoweredBy template directive and (:nopoweredby:) page directive
SDV($AdaptPoweredByEna,1);
SDV($GLOBALS['AdaptPoweredBy'],"Powered by 
        <a target='_blank' href='http://www.pmwiki.org/wiki'
          title='pmwiki.org'>PmWiki</a>\n");
SetTmplDisplay('PagePoweredbyFmt',$AdaptPoweredByEna);

## Load the demo views script if this server is pmwiki.org or if
## AdaptDemoViews is enabled
if (preg_match('!(pmwiki.org)$!', $_SERVER['SERVER_NAME']) ||
    $GLOBALS['AdaptDemoViews']) {
  @include_once("$SkinDir/demoviews.php");
};

