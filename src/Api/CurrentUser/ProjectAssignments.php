<?php
/**
 * ProjectAssignments class.
 */

namespace Required\Harvest\Api\CurrentUser;

use DateTime;
use Required\Harvest\Api\AbstractApi;

/**
 * API client for current user project assignments endpoint.
 *
 * @link https://help.getharvest.com/api-v2/users-api/users/project-assignments/
 */
class ProjectAssignments extends AbstractApi implements ProjectAssignmentsInterface {

	/**
	 * Retrieves a list of project assignments for the current user.
	 *
	 * @throws \Http\Client\Exception
	 *
	 * @param array $parameters {
	 *     Optional. Parameters for filtering the list of project assignments. Default empty array.
	 *
	 *     @type DateTime|string $updated_since  Only return project assignments that have been updated since the given
	 *                                           date and time.
	 * }
	 * @return array|string
	 */
	public function all( array $parameters = [] ) {
		if ( isset( $parameters['updated_since'] ) && $parameters['updated_since'] instanceof DateTime ) {
			$parameters['updated_since'] = $parameters['updated_since']->format( DateTime::ATOM );
		}

		$result = $this->get( '/users/me/project_assignments', $parameters );
		if ( ! isset( $result['project_assignments'] ) || ! \is_array( $result['project_assignments'] ) ) {
			throw new \Required\Harvest\Exception\RuntimeException( 'Unexpected result.' );
		}

		return $result['project_assignments'];
	}
}
