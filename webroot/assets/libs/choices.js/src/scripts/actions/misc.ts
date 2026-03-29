import { ACTION_TYPES } from '../constants';
import { State } from '../interfaces/State';

export interface ClearAllAction {
  type: typeof ACTION_TYPES.CLEAR_ALL;
}

export interface ResetToAction {
  type: typeof ACTION_TYPES.RESET_TO;
  State: State;
}

export interface SetIsLoadingAction {
  type: typeof ACTION_TYPES.SET_IS_LOADING;
  isLoading: boolean;
}

export const clearAll = (): ClearAllAction => ({
  type: ACTION_TYPES.CLEAR_ALL,
});

export const resetTo = (State: State): ResetToAction => ({
  type: ACTION_TYPES.RESET_TO,
  State,
});

export const setIsLoading = (isLoading: boolean): SetIsLoadingAction => ({
  type: ACTION_TYPES.SET_IS_LOADING,
  isLoading,
});
