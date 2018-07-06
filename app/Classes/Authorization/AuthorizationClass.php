<?php

namespace App\Classes\Authorization;

use Dlnsk\HierarchicalRBAC\Authorization;


/**
 *  This is example of hierarchical RBAC authorization configiration.
 */

class AuthorizationClass extends Authorization
{
	public function getPermissions() {
		return [
			'update-post' => [
                    'description' => 'Редактирование любых статей',
                ],
             'update-user' => [
                    'description' => 'Редактирование пользователей',
                ],   
			'editPost' => [
					'description' => 'Edit any posts',   // optional property
					'next' => 'editOwnPost',            // used for making chain (hierarchy) of permissions
				],
			'editOwnPost' => [
					'description' => 'Edit own post',
				],

			//---------------
			'deletePost' => [
					'description' => 'Delete any posts',
				],
		];
	}

	public function getRoles() {
		return [
			'manager' => [
					'update-post',
					'deletePost',
				],
			'user' => [
					'editOwnPost',
				],
		];
	}


	/**
	 * Methods which checking permissions.
	 * Methods should be present only if additional checking needs.
	 */

	public function editOwnPost($user, $post) {
		$post = $this->getModel(\App\Post::class, $post);  // helper method for geting model

		return $user->id === $post->user_id;
	}

}
