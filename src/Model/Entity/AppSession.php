<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AppSession Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property string $ip_address
 * @property string $http_user_agent
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $last_active
 *
 * @property \App\Model\Entity\User $user
 */
class AppSession extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'token'
    ];
}
