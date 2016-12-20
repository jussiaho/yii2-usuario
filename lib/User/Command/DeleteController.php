<?php

/*
 * This file is part of the 2amigos/yii2-usuario project.
 *
 * (c) 2amigOS! <http://2amigos.us/>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Da\User\Command;

use Da\User\Query\UserQuery;
use Yii;
use yii\base\Module;
use yii\console\Controller;
use yii\helpers\Console;

class DeleteController extends Controller
{
    protected $userQuery;

    public function __construct($id, Module $module, UserQuery $userQuery, array $config)
    {
        $this->userQuery = $userQuery;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex($usernameOrEmail)
    {
        if ($this->confirm(Yii::t('user', 'Are you sure? Deleted user can not be restored'))) {
            $user = $this->userQuery->whereUsernameOrEmail($usernameOrEmail)->one();
            if ($user === null) {
                $this->stdout(Yii::t('user', 'User is not found')."\n", Console::FG_RED);
            } else {
                if ($user->delete()) {
                    $this->stdout(Yii::t('user', 'User has been deleted')."\n", Console::FG_GREEN);
                } else {
                    $this->stdout(Yii::t('user', 'Error occurred while deleting user')."\n", Console::FG_RED);
                }
            }
        }
    }
}
