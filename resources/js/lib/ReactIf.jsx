import React from 'react';

export default function ReactIf(props) {
    return props.condition === undefined || !props.condition ? null : <>{props.children}</>;
}
