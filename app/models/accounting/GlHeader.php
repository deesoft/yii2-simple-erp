<?php

namespace app\models\accounting;

use Yii;

/**
 * This is the model class for table "{{%gl_header}}".
 *
 * @property integer $id
 * @property string $number
 * @property string $date
 * @property integer $periode_id
 * @property integer $branch_id
 * @property integer $reff_type
 * @property integer $reff_id
 * @property string $description
 * @property integer $status
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property GlDetail[] $items
 * @property AccPeriode $periode
 */
class GlHeader extends \app\classes\ActiveRecord
{

    const TRANS_CODE = 290;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%gl_header}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['periode_id'], 'default', 'value' => AccPeriode::getActivePeriode()],
            [['Date', 'periode_id', 'branch_id', 'reff_type', 'description', 'status'], 'required'],
            [['date'], 'safe'],
            [['periode_id', 'branch_id', 'reff_type', 'reff_id', 'status'], 'integer'],
            [['!number'], 'autonumber', 'format' => 'formatNumber', 'digit' => 6],
            [['description'], 'string', 'max' => 255],
            [['periode_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccPeriode::className(), 'targetAttribute' => ['periode_id' => 'id']],
        ];
    }

    public function formatNumber()
    {
        $date = date('Ymd');
        return "291.$date.?";
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Number',
            'date' => 'Date',
            'periode_id' => 'Periode ID',
            'branch_id' => 'Branch ID',
            'reff_type' => 'Reff Type',
            'reff_id' => 'Reff ID',
            'description' => 'Description',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(GlDetail::className(), ['header_id' => 'id']);
    }

    public function setItems($values)
    {
        $this->loadRelated('items', $values);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeriode()
    {
        return $this->hasOne(AccPeriode::className(), ['id' => 'periode_id']);
    }
}
