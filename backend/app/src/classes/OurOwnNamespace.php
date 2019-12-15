<?php 
use Slim\Http\Request;

use OurOwnNamespace\TestClass as somethingToTest;

final class TestClass {
 public function __construct() {
 }
 public function testFunction() {
  return 'Happy Test';
 }
}