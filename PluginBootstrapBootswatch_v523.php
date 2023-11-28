<?php
class PluginBootstrapBootswatch_v523{
  private $mysql;
  private $data;
  function __construct(){
    wfPlugin::includeonce('wf/mysql');
    $this->mysql = new PluginWfMysql();
    $this->data = wfPlugin::getPluginSettings('bootstrap/bootswatch_v523', true);
  
  }
  private function db_open(){
    $this->mysql->open($this->data->get('mysql'));
  }
  private function db_select_one(){
    $this->db_open();
    $sql = new PluginWfYml(__DIR__.'/mysql/sql.yml', __FUNCTION__);
    $this->mysql->execute($sql->get());
    $rs = $this->mysql->getOne(array('sql' => $sql->get()));
    return $rs;
  }
  private function db_insert_one(){
    $this->db_open();
    $sql = new PluginWfYml(__DIR__.'/mysql/sql.yml', __FUNCTION__);
    $this->mysql->execute($sql->get());
    return null;
  }
  private function db_update_one($theme){
    /**
     * 
     */
    if(!wfUser::hasRole('client') || !$this->data->get('mysql')){
      return null;
    }
    /**
     * 
     */
    $this->db_open();
    $sql = new PluginWfYml(__DIR__.'/mysql/sql.yml', __FUNCTION__);
    $sql->setByTag(array('theme' => $theme));
    $this->mysql->execute($sql->get());
    return null;
  }
  public static function widget_include($data){
    $data = new PluginWfArray($data);
    $self = new PluginBootstrapBootswatch_v523();
    /**
     * Set other theme in session via querystring.
     */
    if(wfRequest::get('bootstrap_bootswatch_v523_theme')){
      /**
       * 
       */
      if(wfUser::hasRole('client') && $self->data->get('mysql')){
        $rs = $self->db_select_one();
        if(!$rs->get('account_id')){
          $self->db_insert_one();
        }
      }
      /**
       * 
       */
      if(wfRequest::get('bootstrap_bootswatch_v523_theme')=='(default)'){
        /**
         * unset
         */
        wfUser::unsetSession('plugin/bootstrap/bootswatch_v523/theme');
        /**
         * 
         */
        $self->db_update_one('');
      }else{
        /**
         * Check if the theme exist.
         */
        if($self->theme_availible(wfRequest::get('bootstrap_bootswatch_v523_theme'))){
          /**
           * Set in session. 
           */
          wfUser::setSession('plugin/bootstrap/bootswatch_v523/theme', wfRequest::get('bootstrap_bootswatch_v523_theme'));
          /**
           * 
           */
           $self->db_update_one(wfRequest::get('bootstrap_bootswatch_v523_theme'));
        }
      }
    }
    /**
     * Set theme.
     */
    if(wfUser::getSession()->get('plugin/bootstrap/bootswatch_v523/theme')){
      /**
       * If set in Session.
       */
      $data->set('data/theme', wfUser::getSession()->get('plugin/bootstrap/bootswatch_v523/theme'));
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
  public function event_signin(){
    if(wfUser::hasRole('client') && $this->data->get('mysql')){
      $rs = $this->db_select_one();
      if($rs->get('theme') && $this->theme_availible($rs->get('theme'))){
        wfUser::setSession('plugin/bootstrap/bootswatch_v523/theme', $rs->get('theme'));
      }
    }
  }
  private function theme_availible($theme){
    $availible = wfSettings::getSettings('/plugin/bootstrap/bootswatch_v523/theme/availible.yml');
    if(array_search($theme, $availible)!==false){
      return true;
    }else{
      return false;
    }
  }
}
