"use client";
import React from "react";

export function StatusPill({
  children,
  tone = "teal",
}: {
  children: React.ReactNode;
  tone?: "teal" | "red" | "blue" | "gray";
}) {
  return <span className={`pill ${tone}`}>{children}</span>;
}
