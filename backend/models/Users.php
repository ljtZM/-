<?php
/**
 * Team:从容应“队”，NKU
 * coding by 李嘉桐 2212023
 * 用户模型
 */
namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $username
 * @property string $password_hash
 * @property string $email
 * @property string $role
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Articlecomments[] $articlecomments
 * @property Videocomments[] $videocomments
 */
class Users extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $password; // 用来保存原始密码

    /**
     * {@inheritdoc}
     */
    public static function tableName()// 指定该模型对应的数据库表名
    {
        return 'users';
    }

    public function behaviors()// 自动更新时间戳
    {
        return [
            TimestampBehavior::class,
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()// 定义了模型验证规则。规则确保模型数据符合一定的标准
    {
        return [
            [['username', 'password_hash', 'email'], 'required'],
            [['role'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['username', 'password_hash', 'email'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()// 模型属性的标签，用于表单渲染时显示
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password_hash' => 'Password Hash',
            'email' => 'Email',
            'role' => 'Role',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    // 注册时加密密码
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($password);
    }

    // 校验密码
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    // 实现 IdentityInterface 的方法
    //根据用户的 id 查找并返回用户对象。
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    //根据访问令牌查找用户。在实际中，这通常用于基于 API Token 或 OAuth 等机制的认证。该方法目前未实现，但你可以根据需求扩展。
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // 这里可以处理基于 Token 的认证
    }

    //根据用户名查找用户。
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    //返回用户的唯一标识符，这里返回的是用户的 id。
    public function getId()
    {
        return $this->id;
    }

    //返回用户的认证密钥，通常用于后续的认证和授权。
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    //验证传入的认证密钥是否与用户存储的密钥相匹配。
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Gets query for [[Articlecomments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticlecomments()
    {
        return $this->hasMany(Articlecomments::class, ['username' => 'username']);
    }

    /**
     * Gets query for [[Videocomments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVideocomments()
    {
        return $this->hasMany(Videocomments::class, ['username' => 'username']);
    }
}
