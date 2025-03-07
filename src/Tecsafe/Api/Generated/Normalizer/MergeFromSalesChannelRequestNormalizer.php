<?php

namespace Madco\Tecsafe\Tecsafe\Api\Generated\Normalizer;

use Jane\Component\JsonSchemaRuntime\Reference;
use Madco\Tecsafe\Tecsafe\Api\Generated\Runtime\Normalizer\CheckArray;
use Madco\Tecsafe\Tecsafe\Api\Generated\Runtime\Normalizer\ValidatorTrait;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpKernel\Kernel;
if (!class_exists(Kernel::class) or (Kernel::MAJOR_VERSION >= 7 or Kernel::MAJOR_VERSION === 6 and Kernel::MINOR_VERSION === 4)) {
    class MergeFromSalesChannelRequestNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
    {
        use DenormalizerAwareTrait;
        use NormalizerAwareTrait;
        use CheckArray;
        use ValidatorTrait;
        public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
        {
            return $type === \Madco\Tecsafe\Tecsafe\Api\Generated\Model\MergeFromSalesChannelRequest::class;
        }
        public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
        {
            return is_object($data) && get_class($data) === \Madco\Tecsafe\Tecsafe\Api\Generated\Model\MergeFromSalesChannelRequest::class;
        }
        public function denormalize(mixed $data, string $type, string $format = null, array $context = []): mixed
        {
            if (isset($data['$ref'])) {
                return new Reference($data['$ref'], $context['document-origin']);
            }
            if (isset($data['$recursiveRef'])) {
                return new Reference($data['$recursiveRef'], $context['document-origin']);
            }
            $object = new \Madco\Tecsafe\Tecsafe\Api\Generated\Model\MergeFromSalesChannelRequest();
            if (null === $data || false === \is_array($data)) {
                return $object;
            }
            if (\array_key_exists('fromId', $data)) {
                $object->setFromId($data['fromId']);
                unset($data['fromId']);
            }
            if (\array_key_exists('toId', $data)) {
                $object->setToId($data['toId']);
                unset($data['toId']);
            }
            if (\array_key_exists('token', $data)) {
                $object->setToken($data['token']);
                unset($data['token']);
            }
            foreach ($data as $key => $value) {
                if (preg_match('/.*/', (string) $key)) {
                    $object[$key] = $value;
                }
            }
            return $object;
        }
        public function normalize(mixed $object, string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
        {
            $data = [];
            $data['fromId'] = $object->getFromId();
            $data['toId'] = $object->getToId();
            $data['token'] = $object->getToken();
            foreach ($object as $key => $value) {
                if (preg_match('/.*/', (string) $key)) {
                    $data[$key] = $value;
                }
            }
            return $data;
        }
        public function getSupportedTypes(?string $format = null): array
        {
            return [\Madco\Tecsafe\Tecsafe\Api\Generated\Model\MergeFromSalesChannelRequest::class => false];
        }
    }
} else {
    class MergeFromSalesChannelRequestNormalizer implements DenormalizerInterface, NormalizerInterface, DenormalizerAwareInterface, NormalizerAwareInterface
    {
        use DenormalizerAwareTrait;
        use NormalizerAwareTrait;
        use CheckArray;
        use ValidatorTrait;
        public function supportsDenormalization($data, $type, string $format = null, array $context = []): bool
        {
            return $type === \Madco\Tecsafe\Tecsafe\Api\Generated\Model\MergeFromSalesChannelRequest::class;
        }
        public function supportsNormalization(mixed $data, string $format = null, array $context = []): bool
        {
            return is_object($data) && get_class($data) === \Madco\Tecsafe\Tecsafe\Api\Generated\Model\MergeFromSalesChannelRequest::class;
        }
        /**
         * @return mixed
         */
        public function denormalize($data, $type, $format = null, array $context = [])
        {
            if (isset($data['$ref'])) {
                return new Reference($data['$ref'], $context['document-origin']);
            }
            if (isset($data['$recursiveRef'])) {
                return new Reference($data['$recursiveRef'], $context['document-origin']);
            }
            $object = new \Madco\Tecsafe\Tecsafe\Api\Generated\Model\MergeFromSalesChannelRequest();
            if (null === $data || false === \is_array($data)) {
                return $object;
            }
            if (\array_key_exists('fromId', $data)) {
                $object->setFromId($data['fromId']);
                unset($data['fromId']);
            }
            if (\array_key_exists('toId', $data)) {
                $object->setToId($data['toId']);
                unset($data['toId']);
            }
            if (\array_key_exists('token', $data)) {
                $object->setToken($data['token']);
                unset($data['token']);
            }
            foreach ($data as $key => $value) {
                if (preg_match('/.*/', (string) $key)) {
                    $object[$key] = $value;
                }
            }
            return $object;
        }
        /**
         * @return array|string|int|float|bool|\ArrayObject|null
         */
        public function normalize($object, $format = null, array $context = [])
        {
            $data = [];
            $data['fromId'] = $object->getFromId();
            $data['toId'] = $object->getToId();
            $data['token'] = $object->getToken();
            foreach ($object as $key => $value) {
                if (preg_match('/.*/', (string) $key)) {
                    $data[$key] = $value;
                }
            }
            return $data;
        }
        public function getSupportedTypes(?string $format = null): array
        {
            return [\Madco\Tecsafe\Tecsafe\Api\Generated\Model\MergeFromSalesChannelRequest::class => false];
        }
    }
}