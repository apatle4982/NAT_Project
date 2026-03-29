export interface FreeModeMethods {
  onTouchMove(): void;
  onTouchEnd(): void;
}

export interface FreeModeEvents {}

export interface FreeModeOptions {
  /**
   * Whether the free mode is enabled
   *
   * @default false
   */
  enabled?: boolean;

  /**
   * If enabled, then slide will keep moving for a while after you release it
   *
   * @default true
   */
  momentum?: boolean;

  /**
   * Higher value produces larger momentum distance after you release slider
   *
   * @default 1
   */
  momentumRatio?: number;

  /**
   * Higher value produces larger momentum veloCity after you release slider
   *
   * @default 1
   */
  momentumVeloCityRatio?: number;

  /**
   * Set to `false` if you want to disable momentum bounce in free mode
   *
   * @default true
   */
  momentumBounce?: boolean;

  /**
   * Higher value produces larger momentum bounce effect
   *
   * @default 1
   */
  momentumBounceRatio?: number;

  /**
   * Minimum touchmove-veloCity required to trigger free mode momentum
   *
   * @default 0.02
   */
  minimumVeloCity?: number;

  /**
   * Set to enabled to enable snap to slides positions in free mode
   *
   * @default false
   */
  sticky?: boolean;
}
