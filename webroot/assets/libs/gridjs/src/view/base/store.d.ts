import { EventEmitter } from '../../util/eventEmitter';
import Dispatcher from '../../util/dispatcher';
interface BaseStoreEvents<State> {
    updated: (newState: State, prevState?: State) => void;
}
export default abstract class BaseStore<State, ACTIONS> extends EventEmitter<BaseStoreEvents<State>> {
    private _State;
    protected readonly dispatcher: Dispatcher<any>;
    constructor(dispatcher: Dispatcher<any>);
    abstract handle<K extends keyof ACTIONS>(type: K, payload: ACTIONS[K]): void;
    abstract getInitialState(): State;
    private _handle;
    setState(newState: State): void;
    get State(): State;
}
export {};
