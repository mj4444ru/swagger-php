<?php

/**
 * @license Apache 2.0
 */

namespace SwaggerTests;

/**
 * Test if the nesting/parent relations are coherent.
 */
class ValidateRelationsTest extends SwaggerTestCase {

    /**
     *
     * @dataProvider getAnnotations
     * @param string $class
     */
    public function testParents($class) {
        foreach ($class::$parents as $parent) {
            $found = false;
            foreach ($parent::$nested as $nested => $property) {
                if ($nested === $class) {
                    $found = true;
                    break;
                }
            }
            if ($found === false) {
                $this->fail($class . ' not found in ' . $parent . "::\$nested. Found:\n  " . implode("\n  ", array_keys($parent::$nested)));
            }
        }
    }

    /**
     *
     * @dataProvider getAnnotations
     * @param string $class
     */
    public function testNested($class) {
        foreach ($class::$nested as $nested => $property) {
            $found = false;
            foreach ($nested::$parents as $parent) {
                if ($parent === $class) {
                    $found = true;
                    break;
                }
            }
            if ($found === false) {
                $this->fail($class . ' not found in ' . $nested . "::\$parent. Found:\n  " . implode("\n  ", $nested::$parents));
            }
        }
    }

    /**
     * dataProvider for testExample
     * @return array
     */
    public function getAnnotations() {
        $classes = [];
        $dir = new \DirectoryIterator(__DIR__ . '/../src/Annotations');
        foreach ($dir as $entry) {
            if ($entry->getFilename() === 'AbstractAnnotation.php') {
                continue;
            }
            if ($entry->getExtension() === 'php') {
                $classes[] = ['Swagger\Annotations\\' . substr($entry->getFilename(), 0, -4)];
            }
        }
        return $classes;
    }

}