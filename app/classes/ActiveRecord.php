<?php

namespace app\classes;

use Yii;
/**
 * Description of ActiveRecord
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class ActiveRecord extends \yii\db\ActiveRecord
{
    use \dee\db\RelationTrait,
    \mdm\converter\EnumTrait;
    
}
