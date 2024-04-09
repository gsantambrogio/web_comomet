<?php if (!defined('PmWiki')) exit();
/**
* demoviews.php - demo views PHP script for Adapt Skin for PmWiki 
*
* Enable with $AdaptDemoViews = 1; in a configuration file.
*/
global $HTMLStylesFmt, $AdaptLogoFmt, $PageLogoUrl;

# no favicon automatically on pmwiki.org and haganfox.net
if (preg_match('!(pmwiki.org|haganfox.net)$!', $_SERVER['SERVER_NAME']))
  unset($HTMLHeaderFmt['favicon']);

# visitor clicked a demo view button
if ($_REQUEST['demo'] == 'on') {
  $HTMLStylesFmt['demo_views_on'] = "
    .nodemo { display:none; } .nowrap { white-space:nowrap; }\n";
} else { 
  $HTMLStylesFmt['demo_views_off'] = "\n  .onlydemo { display:none; }\n";
}

# site or wiki view
if ($_REQUEST['view']=='site') 
  $HTMLStylesFmt['adaptview'] = "
  /* Adapt skin website view */
  #wikihead a { text-decoration:none; color:black;font-size:1.1em; }
  #wikihead a:hover { text-decoration:underline; color:blue;font-size:1.1em;  }
  #wikicmds, .pagegroup, .pagegroup2 { display:none; }
  .pagetitle { margin-top:8px; } #wikititle { margin-top:8px; margin-bottom:2px; }
  .lastmod { color:#999999; } .grouprc, .allrc, .footnav { display:none; }
  @media (min-width:64em) { #wikilogo { text-align:$LogoAlign; } }\n";

# show/hide old changelog items
if ($_REQUEST['view'] == "changelog") $FmtPV['$view'] = '"changelog"';

# logo choices (text, default, custom)
if (preg_match('!^(default|custom)$!', $_REQUEST['logo'])) {
  if ($_REQUEST['logo']=='default')
    $HTMLStylesFmt['demologo'] = "
    #wikilogo { display:block; }
    @media (min-width:64em) { #wikilogo { text-align:left; } }\n";
  if ($_REQUEST['logo']=='custom') {
    $PageLogoUrl = "$PubDirUrl/skins/adapt/AdaptDemoLogo.gif"; # demo logo
    $HTMLStylesFmt['demologo'] = "
    #wikilogo { display:block; }\n";
  }
  $AdaptLogoFmt = "<div id='wikilogo'><a href='{$ScriptUrl}' title='$WikiTitle'><img
    src='$PageLogoUrl' alt='$WikiTitle' border='0' /></a>$Tagline</div>";
}

# Colors #1
if ($_REQUEST['colors']=='demo1')
  $HTMLStylesFmt['democolors'] = "
  /* Masthead */
  #wikilogotxt, #wikilogo { background:#929296; border-bottom:1px #666666 solid; }
  #wikilogotxt, #wikilogo { color:#000 text-shadow:0.8px 0.8px 0.8px #929296; }
  #wikilogotxt a, #wikilogotxt a:visited { color:#000; }
  #wikilogotxt a:hover { color:#333 text-shadow:1.2px 1.2px 1.2px #929296; }
  #wikihead form a { color:#101010; }
  #wikicmds { background:#e9e9e9; }
  #wikicmds li a { color:#333; }
  #wikicmds li a:hover { text-decoration:underline; color:blue; }
  /* Side Menu */
  #menu { background:#541F14; }
  #menu .sidehead { background:#541F14; border-bottom:1px #404040 solid; }
  #menu form { background:#541F14; }
  #menu .sidesearch { background:#541F14; border-bottom:1px dotted #666; }
  #menu input.inputbox { background:#938172; border:1px dotted #666; }
  #menu .pure-menu li { background:#CC9E61; border-bottom: 1px dotted #666; }
  #menu li a { color:#000; }
  #menu li a:hover { color:#ccc; }
  #menu a { color:#fff; }
  #menu .pure-menu-selected a { color:#999; }
  #menu .pure-menu-heading { color:#444; }
  #menu .sidehead { color:#ccc; }
  #menu .sidehead a:hover { color:#fff }
  #menu .sidesearch { color:#000; }
  #menu input.inputbox { color:#ccc; }
  /* Page area */
  #main { background:#f7f7f7; }\n";

# Colors #2
if ($_REQUEST['colors']=='demo2')
  $HTMLStylesFmt['democolors'] = "
  /* Masthead */
  #wikilogotxt, #wikilogo { background:#A8C0D8; border-bottom:1px #ccc solid; }
  #wikilogotxt, #wikilogo { color:#112233 text-shadow:0.8px 0.8px 0.8px #929296; }
  #wikilogotxt a, #wikilogotxt a:visited { color:#000; }
  #wikilogotxt a:hover { color:#333 text-shadow:1.2px 1.2px 1.2px #929296; }
  #wikihead form a { color:#101010; }
  #wikihead form a:hover { color:blue; text-decoration:underline; }
  #wikihead form a:hover { background-color:transparent; }
  #wikicmds { background:#F0D8D8; }
  #wikicmds li a { color:#333; }
  #wikicmds li a:hover { text-decoration:underline; color:blue; }
  /* Side Menu */
  #menu { background:#A8A8A8; border-right:1px solid #666666; }
  #menu .sidehead { background:#A8A8A8; border-bottom:1px #999 solid; }
  #menu form { background:#A8A8A8; }
  #menu .sidesearch { background:#A8A8A8; border-bottom:1px dotted #666; }
  #menu input.inputbox { background:#DCAE61; border:1px dotted #666; }
  #menu .pure-menu li { background:#DCAE61; border-bottom: 1px dotted #666; }
  #menu .pure-menu-selected a { color:#999; }
  #menu .pure-menu-heading { color:#444; }
  #menu a { color:#333; }
  #menu .sidehead, #menu .sidehead a { color:#304848;  }
  #menu .sidehead a:hover { color:#fff }
  #menu a:hover { color:#ccc }
  #menu .sidesearch { color:#000; }
  #menu input.inputbox { color:#666; }
  /* Page area */
  #main { background:#f7f7f7; }\n";
 
# Serif font in wikitext area
if ($_REQUEST['font']=='serif')
  $HTMLStylesFmt['demofonts'] =  '
  html, .pure-g [class *= "pure-u"] { font-family:
    Georgia, Times, "Times New Roman", serif; }
  #menu, #wikilogotxt, #wikihead, #wikifoot, #wikicmds,
  .title, .caption, h2, h3, h4, h5, h6, .sans { font-family:
    FreeSans, Arimo, "Droid Sans", Helvetica, Arial, sans-serif; }'."\n";

