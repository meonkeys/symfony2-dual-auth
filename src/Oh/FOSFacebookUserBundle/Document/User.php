<?php

namespace Oh\FOSFacebookUserBundle\Document;

use FOS\UserBundle\Document\User as BaseUser;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class User extends BaseUser {

  /**
   * @MongoDB\Id
   */
  protected $id;

  /**
   * @var string
   *
   * @MongoDB\String
   */
  protected $firstname;

  /**
   * @var string
   *
   * @MongoDB\String
   */
  protected $lastname;

  /**
   * @var string
   *
   * @MongoDB\String
   */
  protected $facebookId;

  public function serialize() {
    return serialize(array($this->facebookId, parent::serialize()));
  }

  public function unserialize($data) {
    list($this->facebookId, $parentData) = unserialize($data);
    parent::unserialize($parentData);
  }

  /**
   * @return string
   */
  public function getFirstname() {
    return $this->firstname;
  }

  /**
   * @param string $firstname
   */
  public function setFirstname($firstname) {
    $this->firstname = $firstname;
  }

  /**
   * @return string
   */
  public function getLastname() {
    return $this->lastname;
  }

  /**
   * @param string $lastname
   */
  public function setLastname($lastname) {
    $this->lastname = $lastname;
  }

  /**
   * Get the full name of the user (first + last name)
   * @return string
   */
  public function getFullName() {
    return $this->getFirstName() . ' ' . $this->getLastname();
  }

  /**
   * @param string $facebookId
   * @return void
   */
  public function setFacebookId($facebookId) {
    $this->facebookId = $facebookId;
    $this->setUsername($facebookId);
    $this->salt = '';
  }

  /**
   * @return string
   */
  public function getFacebookId() {
    return $this->facebookId;
  }

  /**
   * @param Array
   */
  public function setFBData($fbdata) {
    if (isset($fbdata['id'])) {
      $this->setFacebookId($fbdata['id']);
      $this->addRole('ROLE_FACEBOOK');
    }
    if (isset($fbdata['first_name'])) {
      $this->setFirstname($fbdata['first_name']);
    }
    if (isset($fbdata['last_name'])) {
      $this->setLastname($fbdata['last_name']);
    }
    if (isset($fbdata['email'])) {
      $this->setEmail($fbdata['email']);
      $this->setUsername($fbdata['email']);
    }
  }

}
