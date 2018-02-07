<?php namespace League\OAuth2\Client\Provider;

use League\OAuth2\Client\Tool\ArrayAccessorTrait;

class AvazaUser implements ResourceOwnerInterface
{
    use ArrayAccessorTrait;

    /**
     * Raw response
     *
     * @var array
     */
    protected $response;

    /**
     * Creates new user.
     *
     * @param array  $response
     */
    public function __construct(array $response)
    {
        $this->response = $response['Users'][0];
    }

    /**
     * Get user id
     *
     * @return string|null
     */
    public function getId()
    {
        return $this->getValueByKey($this->response, 'UserID');
    }

    /**
     * Get user AccountIDFK
     *
     * @return string|null
     */
    public function getAccountIDFK()
    {
        return $this->getValueByKey($this->response, 'AccountIDFK');
    }

    /**
     * Get user email
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->getValueByKey($this->response, 'Email');
    }

    /**
     * Get user first name
     *
     * @return string|null
     */
    public function getFirstName()
    {
        return $this->getValueByKey($this->response, 'Firstname');
    }

    /**
     * Get user last name
     *
     * @return string|null
     */
    public function getLastName()
    {
        return $this->getValueByKey($this->response, 'Lastname');
    }

    /**
     * Get user time zone
     *
     * @return string|null
     */
    public function getTimeZone()
    {
        return $this->getValueByKey($this->response, 'TimeZone');
    }

    /**
     * Get whether the user is a team member.
     *
     * @return boolean|null
     */
    public function getIsTeamMember()
    {
        return $this->getValueByKey($this->response, 'isTeamMember');
    }

    /**
     * Get user CompanyIDFK
     *
     * @return string|null
     */
    public function getCompanyIDFK()
    {
        return $this->getValueByKey($this->response, 'CompanyIDFK');
    }

    /**
     * Get user company name
     *
     * @return string|null
     */
    public function getCompanyName()
    {
        return $this->getValueByKey($this->response, 'CompanyName');
    }

    /**
     * Get user roles
     *
     * @return string|null
     */
    public function getRoles()
    {
        return $this->getValueByKey($this->response, 'Roles');
    }

    /**
     * Return all of the owner details available as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->response;
    }
}