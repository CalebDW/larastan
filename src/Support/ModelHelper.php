<?php

declare(strict_types=1);

namespace Larastan\Larastan\Support;

use Illuminate\Database\Eloquent\Model;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\ReflectionProvider;
use Throwable;

use function is_string;

/** @internal */
final class ModelHelper
{
    public function __construct(private ReflectionProvider $reflectionProvider)
    {
    }

    /** @param ClassReflection|class-string<Model> $model */
    public function getModelInstance(ClassReflection|string $model): Model
    {
        if (is_string($model)) {
            $model = $this->reflectionProvider->getClass($model);
        }

        try {
            /** @var Model $modelInstance */
            $modelInstance = $model->getNativeReflection()->newInstance();
        } catch (Throwable) {
            /** @var Model $modelInstance */
            $modelInstance = $model->getNativeReflection()->newInstanceWithoutConstructor();
        }

        return $modelInstance;
    }
}
