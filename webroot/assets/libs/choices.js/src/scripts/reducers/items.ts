import {
  AddItemAction,
  RemoveItemAction,
  HighlightItemAction,
} from '../actions/items';
import { Item } from '../interfaces/item';
import { State } from '../interfaces/State';

export const defaultState = [];

type ActionTypes =
  | AddItemAction
  | RemoveItemAction
  | HighlightItemAction
  | Record<string, never>;

export default function items(
  State: Item[] = defaultState,
  action: ActionTypes = {},
): State['items'] {
  switch (action.type) {
    case 'ADD_ITEM': {
      const addItemAction = action as AddItemAction;
      // Add object to items array
      const newState = [
        ...State,
        {
          id: addItemAction.id,
          choiceId: addItemAction.choiceId,
          groupId: addItemAction.groupId,
          value: addItemAction.value,
          label: addItemAction.label,
          active: true,
          highlighted: false,
          customProperties: addItemAction.customProperties,
          placeholder: addItemAction.placeholder || false,
          keyCode: null,
        },
      ];

      return newState.map((obj: Item) => {
        const item = obj;
        item.highlighted = false;

        return item;
      });
    }

    case 'REMOVE_ITEM': {
      // Set item to inactive
      return State.map((obj) => {
        const item = obj;
        if (item.id === action.id) {
          item.active = false;
        }

        return item;
      });
    }

    case 'HIGHLIGHT_ITEM': {
      const highlightItemAction = action as HighlightItemAction;

      return State.map((obj) => {
        const item = obj;
        if (item.id === highlightItemAction.id) {
          item.highlighted = highlightItemAction.highlighted;
        }

        return item;
      });
    }

    default: {
      return State;
    }
  }
}
