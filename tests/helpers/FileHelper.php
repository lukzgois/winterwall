<?php

trait FileHelper
{
    /**
     * Assert that the file contains a string.
     *
     * @param string $pattern
     * @param string $file
     * @return $this
     */
    public function seeInFile($pattern, $file)
    {
        $content = file_get_contents($file);

        $this->assertFalse(
            strpos($content, $pattern) === false,
            "The string '$pattern' was not found in '$file'."
        );

        return $this;
    }

    /**
     * Assert that the file don't contains a string.
     *
     * @param  string $pattern
     * @param  string $file
     * @return $this
     */
    public function dontSeeInFile($pattern, $file)
    {
        $content = file_get_contents($file);

        $this->assertTrue(
            strpos($content, $pattern) === false,
            "The string '$pattern' was found in '$file'."
        );

        return $this;
    }
}