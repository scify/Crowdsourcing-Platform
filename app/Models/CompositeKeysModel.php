<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static Builder<static>|CompositeKeysModel newModelQuery()
 * @method static Builder<static>|CompositeKeysModel newQuery()
 * @method static Builder<static>|CompositeKeysModel query()
 *
 * @mixin \Eloquent
 */
class CompositeKeysModel extends Model {
    /**
     * The parent's getKeyName() has no declared return type, so this
     * override narrows nothing and just documents that composite-key
     * subclasses return an array of column names instead of a string.
     *
     * @return string|list<string>
     */
    public function getKeyName() {
        return $this->primaryKey;
    }

    /**
     * Set the keys for a save update query.
     *
     * @param  Builder  $query
     *
     * @return Builder
     */
    protected function setKeysForSaveQuery($query) {
        $keys = $this->getKeyName();
        if (! is_array($keys)) {
            return parent::setKeysForSaveQuery($query);
        }

        foreach ($keys as $keyName) {
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }

        return $query;
    }

    /**
     * Get the primary key value for a save query.
     *
     * @param  mixed  $keyName
     *
     * @return mixed
     */
    protected function getKeyForSaveQuery($keyName = null) {
        if (is_null($keyName)) {
            $keyName = $this->getKeyName();
        }

        return $this->original[$keyName] ?? $this->getAttribute($keyName);
    }
}
