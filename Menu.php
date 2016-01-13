<?php

class Menu extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return CActiveRecord the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{menu}}';
    }

    public function getMenu() {
        $cache_name = md5('model_Menu_getMenu_n');

        $menu = Yii::app()->memcache->get($cache_name);
        if (!$menu) {
            $criteria = new CDbCriteria();
            $criteria->order = 'sort asc';
            $criteria->addColumnCondition(array('status' => 1));
            $menu_data = $this->findAll($criteria);
            $menu_array = array();
            foreach ($menu_data as $key => $one) {
                $url = $one->route ? Yii::app()->createUrl($one->route) : '';
                $icon = $one->icon ? Yii::app()->createUrl($one->icon) : '';
                $menu_array['m_' . $one->id] = array(
                    'id' => $one->id,
                    'parent_id' => $one->parent_id,
