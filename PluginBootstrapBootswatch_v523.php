<?php
class PluginBootstrapBootswatch_v523{
  public static function widget_include($data){
    $data = new PluginWfArray($data);
    /**
     * Set other theme in session via querystring.
     */
    if(wfRequest::get('bootstrap_bootswatch_v523_theme')){
      if(wfRequest::get('bootstrap_bootswatch_v523_theme')=='(none)'){
        /**
         * unset
         */
        unset($_SESSION['plugin']['bootstrap']['bootswatch_v523']['theme']);
      }else{
        /**
         * Check if the theme exist.
         */
        $availible = wfSettings::getSettings('/plugin/bootstrap/bootswatch_v523/theme/availible.yml');
        if(array_search(wfRequest::get('bootstrap_bootswatch_v523_theme'), $availible)!==false){
          /**
           * Set in session. 
           */
          $_SESSION['plugin']['bootstrap']['bootswatch_v523']['theme'] = wfRequest::get('bootstrap_bootswatch_v523_theme');
        }
      }
    }
    /**
     * Set theme.
     */
    if(isset($_SESSION['plugin']['bootstrap']['bootswatch_v523']['theme'])){
      /**
       * If set in Session.
       */
      $data->set('data/theme', $_SESSION['plugin']['bootstrap']['bootswatch_v523']['theme']);
    }elseif(!$data->get('data/theme')){
      /**
       * If not set in widget we set Cerulean as default theme.
       */
      $data->set('data/theme', 'Cerulean');
    }else{
      /**
       * The theme is not in session and is set in widget.
       */
    }
    /**
     * Set current theme to pic upp in selectbox widget.
     */
    if(!wfUser::getSession()->get('plugin/bootstrap/bootswatch_v523/theme')){
      wfUser::setSession('plugin/bootstrap/bootswatch_v523/theme', $data->get('data/theme'));
    }
    /**
     * Create element and render.
     */
    $element = array();
    $element[] = wfDocument::createHtmlElement('link', null, array('href' => '/plugin/bootstrap/bootswatch_v523/'.strtolower($data->get('data/theme')).'/bootstrap.min.css', 'rel' => 'stylesheet'));
    /**
     * Cerulean fix
     */
    if(strtolower($data->get('data/theme'))=='cerulean'){
      $element[] = wfDocument::createHtmlElement('style', "h1,h2,h3,h4,h5,h6{color:#495057} .navbar button{margin-right:5px} ");
    }
    /**
     * 
     */
    wfDocument::renderElement($element);
  }
  public static function widget_selectbox($data){
    wfPlugin::includeonce('wf/array');
    /**
     * Get settings to pic up default class and method.
     */
    $settings = new PluginWfArray($GLOBALS['sys']['settings']);
    /**
     * Current theme.
     */
    $current_theme = wfUser::getSession()->get('plugin/bootstrap/bootswatch_v523/theme');
    /**
     * Create select.
     */
    $select = wfDocument::createHtmlElementAsObject('select');
    $select->set('attribute/onchange', "location.href='/".$settings->get('default_class')."/".$settings->get('default_method')."/bootstrap_bootswatch_v523_theme/'+this.options[this.selectedIndex].text;");
    $availible = wfSettings::getSettings('/plugin/bootstrap/bootswatch_v523/theme/availible.yml');
    $option = array();
    $option[] = wfDocument::createHtmlElement('option', '', array('value' => ''));
    foreach ($availible as $key => $value) {
      $attribute = array('value' => $value);
      if($value == $current_theme){
        $attribute = array_merge($attribute, array('selected' => 'selected'));
      }
      $option[] = wfDocument::createHtmlElement('option', $value, $attribute, array('i18n' => false));
    }
    $select->set('innerHTML', $option);
    /**
     * Render.
     */
    wfDocument::renderElement(array($select->get()));
  }
}
