import { combineReducers } from 'redux';
import items from './items';
import groups from './groups';
import choices from './choices';
import loading from './loading';
import { cloneObject } from '../lib/utils';

export const defaultState = {
  groups: [],
  items: [],
  choices: [],
  loading: false,
};

const appReducer = combineReducers({
  items,
  groups,
  choices,
  loading,
});

const rootReducer = (passedState, action): object => {
  let State = passedState;
  // If we are clearing all items, groups and options we reassign
  // State and then pass that State to our proper reducer. This isn't
  // mutating our actual State
  // See: http://stackoverflow.com/a/35641992
  if (action.type === 'CLEAR_ALL') {
    State = defaultState;
  } else if (action.type === 'RESET_TO') {
    return cloneObject(action.State);
  }

  return appReducer(State, action);
};

export default rootReducer;
