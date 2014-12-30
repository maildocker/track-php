<?php

class EventDockerTest_EventDocker extends PHPUnit_Framework_TestCase {

    private function compareArray($a, $b) {
      // if the indexes don't match, return immediately
        if (count(array_diff_assoc($a, $b))) {
            return false;
        }
        // we know that the indexes, but maybe not values, match.
        // compare the values between the two arrays
        foreach($a as $k => $v) {
            if ($v !== $b[$k]) {
              return false;
            }
        }
        // we have identical indexes, and no unequal values
        return true;
    }

    public $custom_paramter = array();

    protected function setUp()
    {
        EventDocker::setAppID(null);
        EventDocker::setUser(null,null);
        $this->custom_paramter = array(
            'company' => 'Emailmanager SA',
            'city' => 'Florianópolis',
            'state' => 'SC',
            'country' => 'BR'
        );

    }

    public function testVersion() {
        $this->assertEquals(EventDocker::VERSION, '1.0');
    }

    public function testURL() {
        $this->assertEquals(EventDocker::URL, 'http://trk.maildocker.io/event');
    }

    public function testSetAppID() {
        EventDocker::setAppID('app_id');
        $this->assertEquals('app_id', EventDocker::getAppID());
    }

    public function testSetUserEmail() {
        EventDocker::setUser('email@email.com');
        $user = EventDocker::getUser();
        $data = array(
                'email' => 'email@email.com',
                'name' => null
            );
        $this->assertTrue($this->compareArray($data,$user));
    }

    public function testSetUserEmailAndName() {
        EventDocker::setUser('email@email.com','name');
        $user = EventDocker::getUser();
        $data = array(
                'email' => 'email@email.com',
                'name' => 'name'
            );
        $this->assertTrue($this->compareArray($data,$user));
    }

    public function testDefaultSSL() {
        $this->assertEquals(true, EventDocker::isSSL());
    }

    public function testDisableSSL() {
        EventDocker::disableSSL();
        $this->assertEquals(false, EventDocker::isSSL());
    }

    public function testEnableSSL() {
        EventDocker::disableSSL();
        EventDocker::enableSSL();
        $this->assertEquals(true, EventDocker::isSSL());
    }



    public function testExceptionInitWithAppIdNull() {
        $this->setExpectedException(
          'Exception', 'Parameter "app_id" not defined!'
        );
        EventDocker::init();   
    }

    public function testInitWithParamsNull() {
        EventDocker::setAppID('933ff2214029fffe19c');

        $result = EventDocker::init();   

        $this->assertEquals(200,$result->code);
    }

}
