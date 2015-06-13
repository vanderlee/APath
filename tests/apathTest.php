<?php

class apathTest extends PHPUnit_Framework_TestCase {
	public function testOdd() {
		$this->assertEquals(array('a', 'c'), apath(array('a', 'b', 'c', 'd'), '[odd()]', false));
		$this->assertEquals(array('a', 'c'), apath(array('x' => array('a', 'b', 'c', 'd')), 'x/[odd()]', false));
		$this->assertEquals(array('a'), apath(array('x' => array('a', 'b'), 'y' => array('c', 'd')), 'x/[odd()]', false));
		$this->assertEquals(array('c'), apath(array('x' => array('a', 'b'), 'y' => array('c', 'd')), 'y/[odd()]', false));
		$this->assertEquals(array('a', 'c'), apath(array('x' => array('a', 'b'), 'y' => array('c', 'd')), '*/[odd()]', false));
	}
	
	public function testEven() {
		$this->assertEquals(array('b', 'd'), apath(array('a', 'b', 'c', 'd'), '[even()]', false));
		$this->assertEquals(array('b', 'd'), apath(array('x' => array('a', 'b', 'c', 'd')), 'x/[even()]', false));
		$this->assertEquals(array('b'), apath(array('x' => array('a', 'b'), 'y' => array('c', 'd')), 'x/[even()]', false));
		$this->assertEquals(array('d'), apath(array('x' => array('a', 'b'), 'y' => array('c', 'd')), 'y/[even()]', false));
		$this->assertEquals(array('b', 'd'), apath(array('x' => array('a', 'b'), 'y' => array('c', 'd')), '*/[even()]', false));
	}
	
	public function testFirst() {
		$this->assertEquals(array('a'), apath(array('a', 'b', 'c', 'd'), '[first()]', false));
		$this->assertEquals(array('a'), apath(array('x' => array('a', 'b', 'c', 'd')), 'x/[first()]', false));
		$this->assertEquals(array('a'), apath(array('x' => array('a', 'b'), 'y' => array('c', 'd')), 'x/[first()]', false));
		$this->assertEquals(array('c'), apath(array('x' => array('a', 'b'), 'y' => array('c', 'd')), 'y/[first()]', false));
		$this->assertEquals(array('a', 'c'), apath(array('x' => array('a', 'b'), 'y' => array('c', 'd')), '*/[first()]', false));
	}
	
	public function testLast() {
		$this->assertEquals(array('d'), apath(array('a', 'b', 'c', 'd'), '[last()]', false));
		$this->assertEquals(array('d'), apath(array('x' => array('a', 'b', 'c', 'd')), 'x/[last()]', false));
		$this->assertEquals(array('b'), apath(array('x' => array('a', 'b'), 'y' => array('c', 'd')), 'x/[last()]', false));
		$this->assertEquals(array('d'), apath(array('x' => array('a', 'b'), 'y' => array('c', 'd')), 'y/[last()]', false));
		$this->assertEquals(array('b', 'd'), apath(array('x' => array('a', 'b'), 'y' => array('c', 'd')), '*/[last()]', false));
	}	
	
	public function testPosition() {
		$this->assertEquals(array(), apath(array('a', 'b', 'c', 'd'), '[position()=0]', false));
		$this->assertEquals(array('a'), apath(array('a', 'b', 'c', 'd'), '[position()=1]', false));
		$this->assertEquals(array('b'), apath(array('a', 'b', 'c', 'd'), '[position()=2]', false));
		$this->assertEquals(array('c'), apath(array('a', 'b', 'c', 'd'), '[position()=3]', false));
		$this->assertEquals(array('d'), apath(array('a', 'b', 'c', 'd'), '[position()=4]', false));
		$this->assertEquals(array(), apath(array('a', 'b', 'c', 'd'), '[position()=5]', false));
		$this->assertEquals(array('b'), apath(array('x' => array('a', 'b', 'c', 'd')), 'x/[position()=2]', false));
		$this->assertEquals(array('b'), apath(array('x' => array('a', 'b'), 'y' => array('c', 'd')), 'x/[position()=2]', false));
		$this->assertEquals(array('d'), apath(array('x' => array('a', 'b'), 'y' => array('c', 'd')), 'y/[position()=2]', false));
		$this->assertEquals(array('b', 'd'), apath(array('x' => array('a', 'b'), 'y' => array('c', 'd')), '*/[position()=2]', false));
	}	
}
