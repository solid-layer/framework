<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Lang;

use Clarity\Exceptions\FileNotFoundException;

/**
 * Getting a content translation based on the setting.
 */
class Lang
{
    /**
     * @var string
     */
    private $language;

    /**
     * @var string
     */
    private $dir;

    /**
     * Set the language.
     *
     * @param string $language
     * @return mixed|\Clarity\Lang\Lang
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Set the language directory.
     *
     * @param string $dir
     * @return mixed|\Clarity\Lang\Lang
     */
    public function setLangDir($dir)
    {
        $this->dir = $dir;

        return $this;
    }

    /**
     * Get attribute.
     *
     * @param string $path
     * @return array
     */
    protected function getAttribute($path)
    {
        $exploded = explode('.', $path);

        return [
            'file'     => $this->dir.'/'.$this->language.'/'.$exploded[ 0 ].'.php',
            'exploded' => $exploded,
        ];
    }

    /**
     * Check if file exists.
     *
     * @param string $file
     * @return bool
     */
    protected function hasFile($file)
    {
        if (! file_exists($file)) {
            return false;
        }

        return true;
    }

    /**
     * Get a file based on dot.
     *
     * @param string $file
     * @return array
     */
    protected function getDottedFile($file)
    {
        $array = require $file;

        return array_dot($array);
    }

    /**
     * Short way to check if path exists.
     *
     * @param string $path
     * @return bool
     */
    public function has($path)
    {
        $attribute = $this->getAttribute($path);

        if (! $this->hasFile($attribute[ 'file' ])) {
            return false;
        }

        return true;
    }

    /**
     * Get a language translation.
     *
     * @param string $path
     * @param array $params
     * @return string
     */
    public function get($path, $params = [])
    {
        $attribute = $this->getAttribute($path);

        $file = $attribute['file'];

        if (! $this->hasFile($file)) {
            throw new FileNotFoundException("File {$file} not found!");
        }

        # get all the arrays with messages
        $templates = $this->getDottedFile($file);

        # get the file name
        $file_name = $attribute['exploded'][0];

        # get the recursive search of key
        $recursive = substr($path, strlen($file_name) + 1);

        # get the message content
        $content = $templates[ $recursive ];

        if (count($params)) {
            foreach ($params as $key => $val) {
                $content = str_replace('{'.$key.'}', $val, $content);
                $content = str_replace(':'.$key, $val, $content);
            }
        }

        return $content;
    }
}
