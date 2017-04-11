<?php

/**
 * PhalconSlayer\Framework.
 *
 * @copyright 2015-2016 Daison Carino <daison12006013@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://docs.phalconslayer.com
 */

namespace Clarity\Support\Phalcon;

use Exception;
use Phalcon\Crypt as BaseCrypt;

/**
 * Overriding the existing Phalcon\Crypt.
 */
class Crypt extends BaseCrypt
{
    /**
     * Get the openssl options.
     *
     * @return string
     */
    protected function _getOptions()
    {
        return false;
        // return OPENSSL_RAW_DATA;
    }

    /**
     * Get the initialization vector size.
     *
     * @return string
     */
    protected function _getIV($iv_size)
    {
        return str_random($iv_size);
        // return openssl_random_pseudo_bytes($iv_size);
    }

    /**
     * {@inheritdoc}
     */
    public function encrypt($text, $key = null)
    {
        if (! function_exists('openssl_cipher_iv_length')) {
            throw new Exception('openssl extension is required');
        }

        if ($encrypt_key = $key === null) {
            $encrypt_key = $this->getKey();
        }

        if (empty($encrypt_key)) {
            throw new Exception('Encryption key cannot be empty');
        }

        $cipher = $this->getCipher();
        $mode = strtolower(substr($cipher, strrpos($cipher, '-') - strlen($cipher)));

        if (! in_array($cipher, openssl_get_cipher_methods())) {
            throw new Exception('Cipher algorithm is unknown');
        }

        $iv_size = openssl_cipher_iv_length($cipher);
        $block_size = openssl_cipher_iv_length(str_ireplace('-'.$mode, '', $cipher));

        if ($iv_size > 0) {
            $block_size = $iv_size;
        }

        $iv = $this->_getIV($iv_size);

        $padding_type = $this->_padding;

        $padded = $text;

        if ($padding_type != 0 && ($mode == 'cbc' || $mode == 'ecb')) {
            $padded = $this->_cryptPadText($text, $mode, $block_size, $padding_type);
        }

        return $iv.openssl_encrypt($padded, $cipher, $encrypt_key, $this->_getOptions(), $iv);
    }

    /**
     * {@inheritdoc}
     */
    public function decrypt($text, $key = null)
    {
        if (! function_exists('openssl_cipher_iv_length')) {
            throw new Exception('openssl extension is required');
        }

        if ($decrypt_key = $key === null) {
            $decrypt_key = $this->_key;
        }

        if (empty($decrypt_key)) {
            throw new Exception('Decryption key cannot be empty.');
        }

        $cipher = $this->_cipher;
        $mode = strtolower(substr($cipher, strrpos($cipher, '-') - strlen($cipher)));

        if (! in_array($cipher, openssl_get_cipher_methods())) {
            throw new Exception('Cipher algorithm is unknown');
        }

        $ivSize = openssl_cipher_iv_length($cipher);

        $block_size = openssl_cipher_iv_length(str_ireplace('-'.$mode, '', $cipher));

        if ($ivSize > 0) {
            $block_size = $ivSize;
        }

        $decrypted = openssl_decrypt(substr($text, $ivSize), $cipher, $decrypt_key, $this->_getOptions(), substr($text, 0, $ivSize));

        $padding_type = $this->_padding;

        if ($mode == '-cbc' || $mode == '-ecb') {
            return $this->_cryptUnpadText($decrypted, $mode, $block_size, $padding_type);
        }

        return $decrypted;
    }
}
