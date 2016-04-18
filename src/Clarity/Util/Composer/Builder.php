<?php
namespace Clarity\Util\Composer;

use Composer\IO\NullIO;
use Composer\Util\ConfigValidator;
use Composer\Package\Loader\ValidatingArrayLoader;

class Builder
{
    private $config;

    public function config($config)
    {
        $this->config = json_decode($config, true);

        return $this;
    }

    /**
     * This overwrite/create a new key-value
     *
     * @param string $key
     * @param int|string|bool|mixed $value
     */
    public function set($key, $value)
    {
        $this->config[$key] = $value;

        return $this;
    }

    /**
     * This merges an existing key
     *
     * @param  string $key   The key to use
     * @param  array  $value Array value to be merged
     * @return \Clarity\Util\Composer\Builder
     */
    public function merge($key, array $value)
    {
        $this->config[$key] = array_merge_recursive(
            $this->config[$key],
            $value
        );

        return $this;
    }

    /**
     * This compile the config
     *
     * @param  int $format Will be used for 2nd arg in json_encode
     * @return string The final composer content
     */
    public function render($format = JSON_PRETTY_PRINT)
    {
        return str_replace(
            '\/',
            '/',
            json_encode($this->config, $format)
        );
    }

    /**
     * Return the raw config
     *
     * @return mixed Array of config
     */
    public function toArray()
    {
        return $this->config;
    }

    /**
     * Validate config
     *
     * @param  int $check_all
     * @return mixed
     */
    public function validate($check_all = ValidatingArrayLoader::CHECK_ALL)
    {
        $tmpfile = tmpfile();
        fwrite($tmpfile, $this->render());
        fseek($tmpfile, 0);
        $metadata = stream_get_meta_data($tmpfile);

        $validator = new ConfigValidator(new NullIO);
        list($errors, $publish_errors, $warnings) = $validator->validate($metadata['uri'], $check_all);

        fclose($tmpfile);

        if (!empty($errors)) {
            return [
                'valid' => false,
                'errors' => $errors,
            ];
        }

        if (!empty($publish_errors)) {
            return [
                'valid' => false,
                'errors' => $publish_errors,
            ];
        }

        return [
            'valid' => true,
            'warnings' => $warnings,
        ];
    }
}
