<?php
/**
 * Created by PhpStorm.
 * User: Donii Sergii <doniysa@gmail.com>
 * Date: 11/9/17
 * Time: 3:44 PM
 */

/**
 * @class  CallTest
 * <summary>
 *
 * @author Donii Sergii <doniysa@gmail.com>
 */
class CallTest extends Codeception\TestCase\Test
{
    /**
     * @var \Thruway\Message\ErrorMessage[]|\Thruway\CallResult[]
     *
     * @author Donii Sergii <doniysa@gmail.com>
     */
    protected $_data;

    public $messagePattern = null;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->_data = $data;
    }

    public function testClientCall() {
        if (isset($this->_data['error'])) {
            $this->assertInstanceOf(\Thruway\Message\ErrorMessage::class, $this->_data['error']);
            $this->assertEquals(48, $this->_data['error']->getErrorMsgCode());
        }

        if ($this->_data['message']) {
            $this->assertInstanceOf(\Thruway\CallResult::class, $this->_data['message']);
            $this->assertEquals($this->messagePattern, $this->_data['message']->getResultMessage());
        }
    }
}